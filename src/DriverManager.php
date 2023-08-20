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

/**
 * @template I
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
     * @var list<I>
     */
    protected $drivers = [];

    /**
     * @param string $name
     * @param I $driver
     * @return void
     */
    public function addDriver(string $name, $driver)
    {
        $this->drivers[$name] = $driver;
    }

    /**
     * @param bool $inverse
     * @return list<I>
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
