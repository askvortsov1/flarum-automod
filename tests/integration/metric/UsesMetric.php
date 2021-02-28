<?php

/*
 * This file is part of askvortsov/flarum-trust-levels
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Tests\integration\metric;

use Askvortsov\TrustLevels\TrustLevel;

trait UsesMetric
{
    public function genTrustLevel($name, $groupId, $metrics)
    {
        $trustLevel = new TrustLevel();
        $trustLevel->name = $name;
        $trustLevel->group_id = $groupId;

        foreach ($metrics as $metricKey => $metric) {
            $trustLevel->setMetric($metricKey, $metric[0], $metric[1]);
        }

        $trustLevel->calcMetrics();

        return $trustLevel->getAttributes();
    }
}
