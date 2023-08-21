<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator;

use Askvortsov\AutoModerator\Action\ActionDriverInterface;
use Askvortsov\AutoModerator\Action\ActionManager;
use Askvortsov\AutoModerator\DriverManager;
use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Askvortsov\AutoModerator\Metric\MetricManager;
use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Askvortsov\AutoModerator\Requirement\RequirementManager;
use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Askvortsov\AutoModerator\Trigger\TriggerManager;
use Flarum\Filesystem\DriverInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\User;
use Illuminate\Support\Arr;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\MessageBag as MessageBagConcrete;

/**
 * @template E
 */
class Rule
{
    /**
     * @var class-string<TriggerDriverInterface<E>>
     */
    public $triggerId;

    /**
     * @var list<array{id: class-string<ActionDriverInterface>, settings: array<string, mixed>, negate: bool}>
     */
    public $actions;

    /**
     * @var list<array{id: class-string<MetricDriverInterface>, min: int, max: int, negate: bool}>
     */
    public $metrics;

    /**
     * @var list<array{id: class-string<RequirementDriverInterface>, settings: array<string, mixed>}>
     */
    public $requirements;

    /**
     * @var int
     */
    public $lastEditedById;

    public function __construct(array $json)
    {
        $this->triggerId = $json['trigger'];
        $this->actions = $json['actions'];
        $this->metrics = $json['metrics'];
        $this->requirements = $json['requirements'];
        $this->requirements = $json['requirements'];
        $this->lastEditedById = $json['lastEditedById'];
    }

    public function execute(mixed $event)
    {
        /** @var TriggerManager $triggerManager */
        $triggerManager = resolve(TriggerManager::class);
        /** @var ActionManager $actionManager */
        $actionManager = resolve(ActionManager::class);
        /** @var MetricManager $metricManager */
        $metricManager = resolve(MetricManager::class);
        /** @var RequirementManager $requirementManager */
        $requirementManager = resolve(RequirementManager::class);

        $triggerDriver = $triggerManager->getDriver($this->triggerId);
        if ($triggerDriver === null) {
            return;
        }

        if (!$this->isValid($triggerManager, $actionManager, $metricManager, $requirementManager)) {
            return;
        }

        $satisfiesMetrics = collect($this->metrics)->every(function ($metricConfig) use ($event, $triggerDriver, $metricManager) {
            $metricDriver = $metricManager->getDriver($metricConfig['id']);
            if ($metricDriver === null) {
                // Shouldn't get here due to `isValid` checks.
                return false;
            }

            $subject = $triggerDriver->getSubject($metricDriver->subject(), $event);

            $metricVal = $metricDriver->getValue($subject);

            $min = Arr::get($metricConfig, "min",  -1);
            $max = Arr::get($metricConfig, "max",  -1);
            $withinRange = ($min === -1 || $metricVal >= $min) && ($max === -1 || $metricVal <= $max);

            return $metricConfig['negate'] xor $withinRange;
        });

        if (!$satisfiesMetrics) {
            // Shouldn't get here due to `isValid` checks.
            return;
        }

        $satisfiesRequirements = collect($this->requirements)->every(function ($reqConfig) use ($event, $triggerDriver, $requirementManager) {
            $reqDriver = $requirementManager->getDriver($reqConfig['id']);
            if ($reqDriver === null) {
                return false;
            }

            $subject = $triggerDriver->getSubject($reqDriver->subject(), $event);

            $settings = Arr::get($reqConfig, 'settings', []);
            return $reqConfig['negate'] xor $reqDriver->subjectSatisfies($subject, $settings);
        });

        if (!$satisfiesRequirements) {
            return;
        }

        $lastEditedBy = User::find($this->lastEditedById);

        collect($this->actions)->each(function ($actionConfig) use ($event, $triggerDriver, $actionManager, $lastEditedBy) {
            $actionDriver = $actionManager->getDriver($actionConfig['id']);
            if ($actionDriver === null) {
                return false;
            }

            $subject = $triggerDriver->getSubject($actionDriver->subject(), $event);

            $settings = Arr::get($actionConfig, 'settings', []);
            $actionDriver->execute($subject, $settings, $lastEditedBy);
        });
    }

    public function isValid(TriggerManager $triggers, ActionManager $actions, MetricManager $metrics, RequirementManager $requirements)
    {
        return $this->validateDrivers($triggers, [['id' => $this->triggerId]]) &&
            $this->validateDrivers($actions, $this->actions) &&
            $this->validateDrivers($metrics, $this->metrics) &&
            $this->validateDrivers($requirements, $this->requirements) &&
            $this->invalidDriverSettings($actions, $this->actions)->isEmpty() &&
            $this->invalidDriverSettings($requirements, $this->requirements)->isEmpty();
    }

    /**
     * @param DriverManager $drivers
     * @param list<array{id: class-string}> $driverConfigs
     * @return bool
     */
    protected function validateDrivers(DriverManager $drivers, array $driverConfigs): bool
    {
        $driversWithMissingExts = $drivers->getDrivers(true);
        $hasDriversWithMissingExts = collect($driverConfigs)
            ->some(function ($driverConfig) use ($driversWithMissingExts) {
                return array_key_exists($driverConfig['id'], $driversWithMissingExts);
            });

        $allDrivers = $drivers->getDrivers();
        $hasDriversMissing = collect($driverConfigs)
            ->some(function ($driver) use ($allDrivers) {
                return !array_key_exists($driver['id'], $allDrivers);
            });

        return !$hasDriversWithMissingExts && !$hasDriversMissing;
    }

    /**
     * @template T of DriverWithSettingsInterface
     * @param DriverManager<T> $drivers
     * @param list<array{id: class-string<T>, settings: array<string, mixed>}> $driverConfigs
     * @return MessageBag
     */
    public function invalidDriverSettings(DriverManager $drivers, array $driverConfigs): MessageBag
    {
        $factory = resolve(Factory::class);
        $allDrivers = $drivers->getDrivers();


        return collect($driverConfigs)
            ->reduce(function (MessageBag $acc, $driverConfig) use ($allDrivers, $factory) {
                if (($driver = Arr::get($allDrivers, $driverConfig['id']))) {
                    /** @var MessageBagConcrete */
                    $errors = $driver->validateSettings($driverConfig['settings'], $factory);

                    return $acc->merge($errors->getMessages());
                }

                return $acc;
            }, new MessageBagConcrete());
    }

    /**
     * @param SettingsRepositoryInterface $settings
     * @return list<Rule>
     */
    public static function fromSettings(SettingsRepositoryInterface $settings): array
    {
        $raw = $settings->get('automod-rules', '[]');
        $json = json_decode($raw);

        return collect($json)->map(function ($ruleJson) {
            return new Rule($ruleJson);
        })->toArray();
    }
}
