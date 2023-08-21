<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Provider;

use Askvortsov\AutoModerator\Rule;
use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Askvortsov\AutoModerator\Trigger\TriggerManager;
use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class AutoModeratorProvider extends AbstractServiceProvider
{
    public function boot(Dispatcher $events, SettingsRepositoryInterface $settings, TriggerManager $triggerManager)
    {
        $rules = Rule::fromSettings($settings);
        $rulesByTriggers = collect($rules)->groupBy(fn(Rule $r) => $r->triggerId);

        collect($triggerManager->getDrivers())
            ->each(function (TriggerDriverInterface $trigger) use ($events, $rulesByTriggers) {
                $triggerClass = get_class($trigger);
                /**
                 * @var array<Rule> $rules
                 */
                $rules = $rulesByTriggers->get($triggerClass, []);

                $events->listen($trigger->eventClass(), function ($e) use ($rules) {
                    collect($rules)->each(fn(Rule $r) => $r->execute($e));
                });
            });
    }
}
