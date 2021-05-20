<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator;

use Askvortsov\AutoModerator\Action\ActionManager;
use Askvortsov\AutoModerator\Metric\MetricManager;
use Askvortsov\AutoModerator\Requirement\RequirementManager;
use Flarum\Database\AbstractModel;
use Flarum\Database\ScopeVisibilityTrait;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag as MessageBagConcrete;

class Criterion extends AbstractModel
{
    use ScopeVisibilityTrait;

    protected $table = 'criteria';

    protected $attributes = [
        'actions' => '[]',
        'metrics' => '[]',
        'requirements' => '[]',
    ];

    protected $casts = [
        'actions' => 'array',
        'metrics' => 'array',
        'requirements' => 'array',
    ];

    public static function build(string $name, int $lastEditedById, string $icon, string $description, array $actions, array $metrics, array $requirements)
    {
        $criterion = new static();

        $criterion->last_edited_by_id = $lastEditedById;
        $criterion->name = $name;
        $criterion->icon = $icon;
        $criterion->description = $description;
        $criterion->actions = $actions;
        $criterion->metrics = $metrics;
        $criterion->requirements = $requirements;

        return $criterion;
    }

    public function isValid(ActionManager $actions, MetricManager $metrics, RequirementManager $requirements) {
        return $this->validateDrivers($actions, $this->actions) &&
            $this->validateDrivers($metrics, $this->metrics) &&
            $this->validateDrivers($requirements, $this->requirements) &&
            $this->invalidDriverSettings($actions, $this->actions)->isEmpty() &&
            $this->invalidDriverSettings($requirements, $this->requirements)->isEmpty();
    }

    protected function validateDrivers(DriverManagerInterface $drivers, array $config)
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

    public function invalidDriverSettings(DriverManagerInterface $drivers, array $config): MessageBag
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

    public function lastEditedBy()
    {
        return $this->belongsTo(User::class, 'last_edited_by_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'criterion_user');
    }
}
