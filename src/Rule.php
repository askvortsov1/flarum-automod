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
use Askvortsov\AutoModerator\Metric\MetricManager;
use Askvortsov\AutoModerator\Requirement\RequirementManager;
use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Askvortsov\AutoModerator\Trigger\TriggerManager;
use Flarum\Filesystem\DriverInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Support\Arr;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Support\MessageBag as MessageBagConcrete;

class Rule
{
    /**
     * @var class-string<TriggerDriverInterface>
     */
    public $trigger;

    /**
     * @var list<array{type: class-string<ActionDriverInterface>; settings: array<string, mixed>}>
     */
    public $actions;

    /**
     * @var list<array{type: class-string<ActionDriverInterface>; settings: array<string, mixed>}>
     */
    public $metrics;

    /**
     * @var list<array{type: class-string<ActionDriverInterface>; settings: array<string, mixed>}>
     */
    public $requirements;

    public function __construct(array $json)
    {
        $this->trigger = $json['trigger'];
        $this->actions = $json['actions'];
        $this->metrics = $json['metrics'];
        $this->requirements = $json['requirements'];
    }

    public function isValid(TriggerManager $triggers, ActionManager $actions, MetricManager $metrics, RequirementManager $requirements)
    {
        return $this->validateDrivers($triggers, ['type' => $this->trigger]) &&
            $this->validateDrivers($actions, $this->actions) &&
            $this->validateDrivers($metrics, $this->metrics) &&
            $this->validateDrivers($requirements, $this->requirements) &&
            $this->invalidDriverSettings($actions, $this->actions)->isEmpty() &&
            $this->invalidDriverSettings($requirements, $this->requirements)->isEmpty();
    }

    /**
     * @template T of DriverInterface
     * @param DriverManager<T> $drivers
     * @param list<array{type: class-string<T>}> $config
     * @return bool
     */
    protected function validateDrivers(DriverManager $drivers, array $config): bool
    {
        $driversWithMissingExts = $drivers->getDrivers(true);
        $hasDriversWithMissingExts = collect($config)
            ->some(function ($driverConfig) use ($driversWithMissingExts) {
                return array_key_exists($driverConfig['type'], $driversWithMissingExts);
            });

        $allDrivers = $drivers->getDrivers();
        $hasDriversMissing = collect($this->drivers)
            ->some(function ($driver) use ($allDrivers) {
                return !array_key_exists($driver['type'], $allDrivers);
            });

        return !$hasDriversWithMissingExts && !$hasDriversMissing;
    }

    /**
     * @template T of DriverWithSettingsInterface
     * @param DriverManager<T> $drivers
     * @param list<array{type: class-string<T>, settings: array<string, mixed>}> $config
     * @return MessageBag
     */
    public function invalidDriverSettings(DriverManager $drivers, array $config): MessageBag
    {
        $factory = resolve(Factory::class);
        $allDrivers = $drivers->getDrivers();


        return collect($config)
            ->reduce(function (MessageBag $acc, $driverConfig) use ($allDrivers, $factory) {
                if (($driver = Arr::get($allDrivers, $driverConfig['type']))) {
                    /** @var MessageBag */
                    $errors = $driver->validateSettings($driverConfig['settings'], $factory);

                    return $acc->merge($errors);
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
