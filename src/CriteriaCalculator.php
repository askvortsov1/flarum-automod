<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator;

use Askvortsov\AutoModerator\Action\ActionManager;
use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Askvortsov\AutoModerator\Metric\MetricManager;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;
use Illuminate\Support\Arr;

class CriteriaCalculator
{
    /**
     * @var ActionManager
     */
    protected $actions;

    /**
     * @var MetricManager
     */
    protected $metrics;

    public function __construct(ActionManager $actions, MetricManager $metrics)
    {
        $this->actions = $actions;
        $this->metrics = $metrics;
    }

    protected $prevRuns = [];

    public function recalculate(User $user, string $eventClass)
    {
        $metrics = $this->calcMetrics($user);

        $prevCriteria = CriteriaCalculator::toAssoc($user->criteria->toArray());
        $currCriteria = CriteriaCalculator::toAssoc($this->getCriteriaForStats($metrics));

        $lostCriteria = array_diff_key($prevCriteria, $currCriteria);
        $gainedCriteria = array_diff_key($currCriteria, $prevCriteria);

        $relevantCriteria = CriteriaCalculator::toAssoc($this->whereTriggeredBy($this->allCriteria(), $eventClass));
        $relevantLostCriteria = array_intersect_key($lostCriteria, $relevantCriteria);
        $relevantGainedCriteria = array_intersect_key($gainedCriteria, $relevantCriteria);

        foreach ($relevantLostCriteria as $criterion) {
            $this->runActions($user, $criterion, false);
        }
        foreach ($relevantGainedCriteria as $criterion) {
            $this->runActions($user, $criterion, true);
        }

        $actualNewCriteria = array_merge(array_diff($prevCriteria, $relevantLostCriteria), $relevantGainedCriteria);
        $user->criteria()->sync(Arr::pluck($actualNewCriteria, 'id'));
    }

    protected function calcMetrics(User $user)
    {
        $metrics = [];

        foreach ($this->metrics->getDrivers() as $name => $driver) {
            $metrics[$name] = $driver->getValue($user);
        }

        return $metrics;
    }

    protected function getCriteriaForStats(array $metrics)
    {
        return $this->allCriteria()
            ->filter(function (Criterion $criterion) use ($metrics) {
                foreach ($criterion->metrics as $metric) {
                    $userVal = Arr::get($metrics, $metric['type']);
                    
                    // Happens when criteria invalid due to missing ext dependencies
                    if ($userVal === null) return false;
                    $min = Arr::get($metric, "min",  -1);
                    $max = Arr::get($metric, "max",  -1);
                    $withinRange = ($min === -1 || $userVal >= $min) && ($max === -1 || $userVal <= $max);

                    if (!$withinRange) {
                        return false;
                    }
                }

                return true;
            })
            ->all();
    }

    protected function whereTriggeredBy($criteria, $eventClass)
    {
        $validCriteria = $criteria
            ->filter(function (Criterion $criterion) {
                return $criterion->isValid($this->actions, $this->metrics);
            });

        if ($eventClass === LoggedIn::class) {
            return $validCriteria;
        }

        $triggeredMetrics = array_filter($this->metrics->getDrivers(), function (MetricDriverInterface $metric) use ($eventClass) {
            return in_array($eventClass, $metric->eventTriggers());
        }, ARRAY_FILTER_USE_KEY);

        return $validCriteria
            ->filter(function (Criterion $criterion) use ($triggeredMetrics) {
                return collect($criterion->metrics)->contains(function ($metric) use ($triggeredMetrics) {
                    return in_array($metric['type'], $triggeredMetrics);
                });
            });
            
    }

    protected $criteria;
    
    protected function allCriteria()
    {
        if (!$this->criteria) {
            $this->criteria = Criterion::all();
        }

        return $this->criteria;
    }

    protected function runActions(User $user, Criterion $criterion, bool $gain)
    {
        $drivers = $this->actions->getDrivers();

        collect($criterion->actions)
            ->filter(function ($action) use ($gain) {
                return $action['gain'] === $gain;
            })
            ->each(function ($action) use ($user, $drivers) {
                $drivers[$action['type']]->execute($user, $action['settings']);
            });
    }

    /**
     * Converts model query results into an associative array with the ID as the key.
     */
    protected static function toAssoc($arr)
    {
        $newArr = [];

        foreach ($arr as $model) {
            $newArr[$model['id']] = $model;
        }

        return $newArr;
    }
}
