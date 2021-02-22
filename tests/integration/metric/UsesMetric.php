<?php

namespace Askvortsov\TrustLevels\Tests\integration\metric;

use Askvortsov\TrustLevels\TrustLevel;

trait UsesMetric
{
    public function genTrustLevel($name, $groupId, $metrics) {
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