<?php

/*
 * This file is part of askvortsov/flarum-trust-levels
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Metric;

use Flarum\Extension\ExtensionManager;

class MetricManager
{
    /**
     * @var ExtensionManager
     */
    protected $extensions;

    public function __construct(ExtensionManager $extensions)
    {
        $this->extensions = $extensions;
    }

    protected $drivers = [];

    public function addDriver(string $name, MetricDriverInterface $driver)
    {
        $this->drivers[$name] = $driver;
    }

    public function getDrivers()
    {
        return array_filter($this->drivers, function (MetricDriverInterface $driver) {
            foreach ($driver->extensionDependencies() as $extensionId) {
                if (!$this->extensions->isEnabled($extensionId)) {
                    return false;
                }
            }

            return true;
        });
    }
}
