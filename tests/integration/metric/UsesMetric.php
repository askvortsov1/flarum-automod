<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\metric;

use Askvortsov\AutoModerator\Criterion;

trait UsesMetric
{
    public function genCriterion($name, $groupId, $rawMetrics)
    {
        $actions = [
            [
                'type' => 'add_to_group',
                'gain' => true,
                'settings' => [
                    'group_id' => $groupId
                ]
            ],
            [
                'type' => 'remove_from_group',
                'gain' => false,
                'settings' => [
                    'group_id' => $groupId
                ]
            ]
        ];

        $metrics = collect($rawMetrics)
            ->map(function (array $range, string $key) {
                return [
                    'type' => $key,
                    'min' => $range[0],
                    'max' => $range[1]
                ];
            })
            ->toArray();

        $criterion = Criterion::build(
            $name,
            '',
            $actions,
            $metrics,
            []
        );

        return $criterion->getAttributes();
    }
}
