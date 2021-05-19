<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Requirement;

use Askvortsov\AutoModerator\DriverManagerInterface;
use Flarum\Extension\ExtensionManager;

class RequirementManager implements DriverManagerInterface
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

    public function addDriver(string $name, RequirementDriverInterface $driver)
    {
        $this->drivers[$name] = $driver;
    }

    public function getDrivers(bool $inverse = false)
    {
        $filtered = array_filter($this->drivers, function (RequirementDriverInterface $driver) {
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
