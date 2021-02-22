<?php

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
