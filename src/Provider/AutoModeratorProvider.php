<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Provider;

use Askvortsov\AutoModerator\CriteriaCalculator;
use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Askvortsov\AutoModerator\Metric\MetricManager;
use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Askvortsov\AutoModerator\Trigger\TriggerManager;
use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\LoggedIn;
use Flarum\User\Event\Registered;
use Illuminate\Contracts\Events\Dispatcher;

class AutoModeratorProvider extends AbstractServiceProvider
{
    public function boot(Dispatcher $events, SettingsRepositoryInterface $settings, TriggerManager $triggerManager)
    {

        $rulesByTriggers = Rule

        $triggers = collect($triggerManager->getDrivers())
            ->each(function (TriggerDriverInterface $trigger) {
                return $trigger->eventClass();
            })
            ->

        $triggers = collect($metrics->getDrivers())
            ->reduce(function (array P$curr, MetricDriverInterface $driver) {
                $formatTriggers = collect($driver->eventTriggers())
                    ->map(function (callable $getUser, string $key) {
                        return [
                            'eventClass' => $key,
                            'getUser' => $getUser
                        ];
                    })
                    ->toArray();
                return array_merge($curr, $formatTriggers);
            }, $universalTriggers);

        collect($triggers)
            ->each(function ($trigger) use ($events) {
                $events->listen($trigger['eventClass'], function ($e) use ($trigger) {
                    $actor = $trigger['getUser']($e);

                    /** @var CriteriaCalculator */
                    $calculator = resolve(CriteriaCalculator::class);

                    $calculator->recalculate($actor, $trigger['eventClass']);
                });
            });
    }
}
