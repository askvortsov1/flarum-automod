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
use Flarum\User\Guest;
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

    public function __construct(array $json)
    {
        $this->triggerId = $json['triggerId'];
        $this->actions = $json['actions'];
        $this->metrics = $json['metrics'] ?? [];
        $this->requirements = $json['requirements'] ?? [];
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

        foreach ($this->metrics as $metricConfig) {
            $metricDriver = $metricManager->getDriver($metricConfig['id']);

            if ($metricDriver === null) {
                // Shouldn't get here due to `isValid` checks.
                return;
            }

            $subject = $triggerDriver->getSubject($metricDriver->subject(), $event);

            $metricVal = $metricDriver->getValue($subject);

            $min = Arr::get($metricConfig, "min",  -1);
            $max = Arr::get($metricConfig, "max",  -1);
            $withinRange = ($min === -1 || $metricVal >= $min) && ($max === -1 || $metricVal <= $max);

            $meets = boolval(Arr::get($metricConfig, 'negate', false)) ^ $withinRange;

            if (!$meets) return;
        }

        foreach ($this->requirements as $reqConfig) {
            $reqDriver = $requirementManager->getDriver($reqConfig['id']);
            if ($reqDriver === null) {
                // Shouldn't get here due to `isValid` checks.
                return;
            }

            $subject = $triggerDriver->getSubject($reqDriver->subject(), $event);

            $settings = Arr::get($reqConfig, 'settings', []);

            $meets = Arr::get($reqConfig, 'negate', false) ^ $reqDriver->subjectSatisfies($subject, $settings);
            if (!$meets) return;
        }

        $lastEditedBy = new Guest();
        // $lastEditedBy = User::find($this->lastEditedById);

        foreach ($this->actions as $actionConfig) {
            $actionDriver = $actionManager->getDriver($actionConfig['id']);
            if ($actionDriver === null) {
                // Shouldn't get here due to `isValid` checks.
                return;
            }

            $subject = $triggerDriver->getSubject($actionDriver->subject(), $event);

            $settings = Arr::get($actionConfig, 'settings', []);
            $actionDriver->execute($subject, $settings, $lastEditedBy);
        }
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
                    $errors = $driver->validateSettings($driverConfig['settings'] ?? [], $factory);

                    return $acc->merge($errors->getMessages());
                }

                return $acc;
            }, new MessageBagConcrete());
    }
}
