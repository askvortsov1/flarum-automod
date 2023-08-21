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

use Flarum\Extension\ExtensionManager;
use Illuminate\Support\Arr;

/**
 * @template I of DriverInterface
 */
abstract class DriverManager
{
    /**
     * @var ExtensionManager
     */
    protected $extensions;

    public function __construct(ExtensionManager $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * @var array<string, I>
     */
    protected $drivers = [];

    /**
     * @param I $driver
     * @return void
     */
    public function addDriver(DriverInterface $driver)
    {
        $name = $driver->id();
        $this->drivers[$name] = $driver;
    }

    /**
     * @param string $id
     * @return I|null
     */
    public function getDriver(string $id)
    {
        $filtered = $this->getDrivers();

        return Arr::get($filtered, $id);
    }

    /**
     * @param bool $inverse
     * @return array<string, I>
     */
    public function getDrivers(bool $inverse = false)
    {
        $filtered = array_filter($this->drivers, function ($driver) {
            foreach ($driver->extensionDependencies() as $extensionId) {
                if (!$this->extensions->isEnabled($extensionId)) {
                    return false;
                }
            }

            return true;
        });

        if ($inverse) {
            return array_diff_key($this->drivers, $filtered);
        }

        return $filtered;
    }
}
