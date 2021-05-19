<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Api\Serializer;

use Askvortsov\AutoModerator\Action\ActionManager;
use Askvortsov\AutoModerator\Metric\MetricManager;
use Askvortsov\AutoModerator\Requirement\RequirementManager;
use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\Api\Serializer\BasicUserSerializer;

class CriterionSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'criteria';

    /**
     * {@inheritdoc}
     */
    protected function getDefaultAttributes($criterion)
    {
        $attributes = [
            'name'                         => $criterion->name,
            'description'                  => $criterion->description,
            'actions'                      => $criterion->actions,
            'metrics'                      => $criterion->metrics,
            'requirements'                 => $criterion->requirements,
            'isValid'                      => $criterion->isValid(resolve(ActionManager::class), resolve(MetricManager::class), resolve(RequirementManager::class)),
            'invalidActionSettings'        => $criterion->invalidActionSettings(resolve(ActionManager::class))->messages()
        ];

        return $attributes;
    }

    protected function users($criterion)
    {
        return $this->hasMany($criterion, BasicUserSerializer::class);
    }
}
