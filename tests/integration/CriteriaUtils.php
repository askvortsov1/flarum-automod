<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration;

use Askvortsov\AutoModerator\Criterion;

class CriteriaUtils
{
    public static function genCriterionGroupManagement($name, $groupId, $metrics = [], $requirements = [], $id = null) {
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

        return CriteriaUtils::genCriterion($name, $actions, $metrics, $requirements, $id);
    }

    public static function genCriterion($name, $actions= [], $metrics = [], $requirements= [], $id = null)
    {
        $criterion = Criterion::build(
            $name,
            1,
            '',
            '',
            $actions,
            $metrics,
            $requirements,
        );

        $attributes = $criterion->getAttributes();

        if ($id !== null) $attributes['id'] = $id;

        return $attributes;
    }
}
