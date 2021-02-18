<?php

namespace Askvortsov\TrustLevels\Tests\integration\range;

use Askvortsov\TrustLevels\TrustLevel;

trait UsesRange
{
    public function genTrustLevel($name, $groupId, $ranges) {
        $trustLevel = new TrustLevel();
        $trustLevel->name = $name;
        $trustLevel->group_id = $groupId;

        foreach ($ranges as $rangeKey => $range) {
            $trustLevel->setRange($rangeKey, $range[0], $range[1]);
        }

        $trustLevel->calcRanges();

        return $trustLevel->getAttributes();
    }
}