<?php

/*
 * This file is part of askvortsov/flarum-trust-levels
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;
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
     *
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
