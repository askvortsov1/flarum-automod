<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Extend;

use Askvortsov\AutoModerator\Action\ActionDriverInterface;
use Askvortsov\AutoModerator\Action\ActionManager;
use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Askvortsov\AutoModerator\Metric\MetricManager;
use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Askvortsov\AutoModerator\Requirement\RequirementManager;
use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Askvortsov\AutoModerator\Trigger\TriggerManager;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

class AutoModerator implements ExtenderInterface
{
    protected $triggerDrivers = [];
    protected $actionDrivers = [];
    protected $metricDrivers = [];
    protected $requirementDrivers = [];

    /**
     * Define a new trigger driver.
     *
     * @param class-string<TriggerDriverInterface> $driver
     */
    public function triggerDriver(string $driver)
    {
        $this->actionDrivers[] = $driver;

        return $this;
    }

    /**
     * Define a new action driver.
     *
     * @param class-string<ActionDriverInterface> $driver
     */
    public function actionDriver(string $driver)
    {
        $this->actionDrivers[] = $driver;

        return $this;
    }

    /**
     * Define a new metric driver.
     *
     * @param class-string<MetricDriverInterface> $driver
     */
    public function metricDriver(string $driver)
    {
        $this->metricDrivers[] = $driver;

        return $this;
    }

    /**
     * Define a new requirement driver.
     *
     * @param class-string<RequirementDriverInterface> $driver
     */
    public function requirementDriver(string $driver)
    {
        $this->requirementDrivers[] = $driver;

        return $this;
    }

    public function extend(Container $container, Extension $extension = null)
    {
        $container->resolving(TriggerManager::class, function ($triggers) use ($container) {
            foreach ($this->triggerDrivers as $driver) {
                $triggers->addDriver($container->make($driver));
            }

            return $triggers;
        });

        $container->resolving(ActionManager::class, function ($actions) use ($container) {
            foreach ($this->actionDrivers as $driver) {
                $actions->addDriver($container->make($driver));
            }

            return $actions;
        });

        $container->resolving(MetricManager::class, function ($metrics) use ($container) {
            foreach ($this->metricDrivers as $driver) {
                $metrics->addDriver($container->make($driver));
            }

            return $metrics;
        });

        $container->resolving(RequirementManager::class, function ($requirements) use ($container) {
            foreach ($this->requirementDrivers as $driver) {
                $requirements->addDriver($container->make($driver));
            }

            return $requirements;
        });
    }
}
