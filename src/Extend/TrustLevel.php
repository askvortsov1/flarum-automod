<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Extend;

use Askvortsov\TrustLevels\Metric\MetricManager;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

class TrustLevel implements ExtenderInterface
{
    protected $drivers = [];

    /**
     * Define a new metric type driver.
     *
     * @param string $name
     * @param string $driver
     */
    public function metricDriver(string $name, string $driver)
    {
        $this->drivers[$name] = $driver;

        return $this;
    }

    /**
     * @deprecated use $this->metricDriver
     * Define a new metric type driver.
     *
     * @param string $name
     * @param string $driver
     */
    public function driver(string $name, string $driver)
    {
        return $this->metricDriver($name, $driver);
    }

    public function extend(Container $container, Extension $extension = null)
    {
        $container->resolving(MetricManager::class, function ($metrics) use ($container) {
            foreach ($this->drivers as $name => $driver) {
                $metrics->addDriver($name, $container->make($driver));
            }

            return $metrics;
        });
    }
}
