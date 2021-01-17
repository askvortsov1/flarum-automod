<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Extend;

use Askvortsov\TrustLevels\Range\RangeManager;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

class TrustLevel implements ExtenderInterface
{
    protected $drivers = [];

    /**
     * Define a new range type driver.
     *
     * @param string $name
     * @param string $driver
     */
    public function driver(string $name, string $driver)
    {
        $this->drivers[$name] = $driver;

        return $this;
    }

    public function extend(Container $container, Extension $extension = null)
    {
        $container->resolving(RangeManager::class, function ($ranges) use ($container) {
            foreach ($this->drivers as $name => $driver) {
                $ranges->addDriver($name, $container->make($driver));
            }

            return $ranges;
        });
    }
}
