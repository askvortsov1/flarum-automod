<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Api\Serializer;

use Askvortsov\TrustLevels\Metric\MetricDriverInterface;
use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\Mail\DriverInterface;
use InvalidArgumentException;

class TrustLevelMetricDriverSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'metric-drivers';

    /**
     * {@inheritdoc}
     *
     * @param array $settings
     * @throws InvalidArgumentException
     */
    protected function getDefaultAttributes($drivers)
    {
        $serializedDrivers = [];

        foreach ($drivers as $name => $driver) {
            $serializedDrivers[$name] = $driver->translationKey();
        }
        return [
            'drivers' => $serializedDrivers,
        ];
    }

    public function getId($model)
    {
        return 'global';
    }
}