<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Extend;

use Askvortsov\AutoModerator\Action\ActionManager;
use Askvortsov\AutoModerator\Metric\MetricManager;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

class AutoModerator implements ExtenderInterface
{
    protected $actionDrivers = [];
    protected $metricDrivers = [];

    /**
     * Define a new action type driver.
     *
     * @param string $name
     * @param string $driver
     */
    public function actionDriver(string $name, string $driver)
    {
        $this->actionDrivers[$name] = $driver;

        return $this;
    }

    /**
     * Define a new metric type driver.
     *
     * @param string $name
     * @param string $driver
     */
    public function metricDriver(string $name, string $driver)
    {
        $this->metricDrivers[$name] = $driver;

        return $this;
    }

    public function extend(Container $container, Extension $extension = null)
    {
        $container->resolving(ActionManager::class, function ($metrics) use ($container) {
            foreach ($this->actionDrivers as $name => $driver) {
                $metrics->addDriver($name, $container->make($driver));
            }

            return $metrics;
        });

        $container->resolving(MetricManager::class, function ($metrics) use ($container) {
            foreach ($this->metricDrivers as $name => $driver) {
                $metrics->addDriver($name, $container->make($driver));
            }

            return $metrics;
        });
    }
}
