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

use Askvortsov\AutoModerator\Action\ActionDriverInterface;
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

    public static function build(string $name, string $description, array $actions, array $metrics, array $requirements)
    {
        $criterion = new static();

        $criterion->name = $name;
        $criterion->description = $description;
        $criterion->actions = $actions;
        $criterion->metrics = $metrics;
        $criterion->requirements = $requirements;

        return $criterion;
    }

    public function isValid(ActionManager $actions, MetricManager $metrics, RequirementManager $requirements) {
        $actionDriversWithMissingExts = $actions->getDrivers(true);
        $hasActionsWithMissingExts = collect($this->actions)
            ->some(function ($action) use ($actionDriversWithMissingExts) {
                return array_key_exists($action['type'], $actionDriversWithMissingExts);
            });

        $metricDriversWithMissingExts = $metrics->getDrivers(true);
        $hasMetricsWithMissingExts = collect($this->metrics)
            ->some(function ($metric) use ($metricDriversWithMissingExts) {
                return array_key_exists($metric['type'], $metricDriversWithMissingExts);
            });

        $requirementDriversWithMissingExts = $requirements->getDrivers(true);
        $hasRequirementsWithMissingExts = collect($this->requirements)
            ->some(function ($requirement) use ($requirementDriversWithMissingExts) {
                return array_key_exists($requirement['type'], $requirementDriversWithMissingExts);
            });

        if ($hasActionsWithMissingExts || $hasMetricsWithMissingExts || $hasRequirementsWithMissingExts) return false;


        $actionDriversMissing = $actions->getDrivers();
        $hasActionsMissing = collect($this->actions)
            ->some(function ($action) use ($actionDriversMissing) {
                return !array_key_exists($action['type'], $actionDriversMissing);
            });

        $metricDriversMissing = $metrics->getDrivers();
        $hasMetricsMissing = collect($this->metrics)
            ->some(function ($metric) use ($metricDriversMissing) {
                return !array_key_exists($metric['type'], $metricDriversMissing);
            });

        $requirementDriversMissing = $requirements->getDrivers();
        $hasRequirementsMissing = collect($this->requirements)
            ->some(function ($requirement) use ($requirementDriversMissing) {
                return !array_key_exists($requirement['type'], $requirementDriversMissing);
            });

        if ($hasActionsMissing || $hasMetricsMissing || $hasRequirementsMissing) return false;

        if ($this->invalidActionSettings($actions)->isNotEmpty()) return false;

        return true;
    }

    public function invalidActionSettings(ActionManager $actions): MessageBag
    {
        $factory = resolve(Factory::class);
        $actionDrivers = $actions->getDrivers();

        return collect($this->actions)
            ->reduce(function (MessageBag $acc, $action) use ($actionDrivers, $factory) {
                /** @var ActionDriverInterface */
                if (($driver = Arr::get($actionDrivers, $action['type']))) {
                    /** @var MessageBag */
                    $errors = $driver->validateSettings($action['settings'], $factory);

                    return $acc->merge($errors);
                }

                return $acc;
            }, new MessageBagConcrete());
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'criterion_user');
    }
}
