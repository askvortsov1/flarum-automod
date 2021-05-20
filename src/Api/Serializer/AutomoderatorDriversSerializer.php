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

use Askvortsov\AutoModerator\Action\ActionDriverInterface;
use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Api\Serializer\AbstractSerializer;

class AutomoderatorDriversSerializer extends AbstractSerializer
{
    protected $type = 'automoderator-drivers';

    protected function getDefaultAttributes($drivers)
    {
        $action = array_merge(
            $this->serializeActionDrivers($drivers['actionDrivers']),
            $this->serializeActionDrivers($drivers['actionDriversMissingExt'], true)
        );

        $metric = array_merge(
            $this->serializeMetricDrivers($drivers['metricDrivers']),
            $this->serializeMetricDrivers($drivers['metricDriversMissingExt'], true)
        );

        $requirement = array_merge(
            $this->serializeRequirementDrivers($drivers['requirementDrivers']),
            $this->serializeRequirementDrivers($drivers['requirementDriversMissingExt'], true)
        );
    
        return [
            'action'      => $action,
            'metric'      => $metric,
            'requirement' => $requirement
        ];
    }

    protected function serializeActionDrivers($drivers, $missingExt = false)
    {
        return collect($drivers)
            ->map(function (ActionDriverInterface $driver) use ($missingExt) {
                return [
                    'availableSettings' => $driver->availableSettings(),
                    'translationKey' => $driver->translationKey(),
                    'missingExt' => $missingExt
                ];
            })
            ->toArray();
    }

    protected function serializeMetricDrivers($drivers, $missingExt = false)
    {
        return collect($drivers)
            ->map(function (MetricDriverInterface $driver) use ($missingExt) {
                return [
                    'translationKey' => $driver->translationKey(),
                    'missingExt' => $missingExt
                ];
            })
            ->toArray();
    }

    protected function serializeRequirementDrivers($drivers, $missingExt = false)
    {
        return collect($drivers)
            ->map(function (RequirementDriverInterface $driver) use ($missingExt) {
                return [
                    'availableSettings' => $driver->availableSettings(),
                    'translationKey' => $driver->translationKey(),
                    'missingExt' => $missingExt
                ];
            })
            ->toArray();
    }

    public function getId($model)
    {
        return 'global';
    }
}
