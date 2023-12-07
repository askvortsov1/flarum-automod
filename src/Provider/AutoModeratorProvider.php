<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Provider;

use Askvortsov\AutoModerator\Rule;
use Askvortsov\AutoModerator\Trigger\TriggerManager;
use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class AutoModeratorProvider extends AbstractServiceProvider
{
    public function boot(Dispatcher $events, SettingsRepositoryInterface $settings, TriggerManager $triggerManager)
    {
        $raw = $settings->get('automod-rules', '[]');
        $json = json_decode($raw, true);

        $rules = collect($json)->map(fn (array $r) => new Rule($r))->toArray();
        $rulesByTriggers = collect($rules)->groupBy(fn (Rule $r) => $r->triggerId);

        foreach ($triggerManager->getDrivers() as $trigger) {
            /**
             * @var array<Rule> $rules
             */
            $rules = $rulesByTriggers->get($trigger->id(), []);

            $events->listen($trigger->eventClass(), function ($e) use ($rules) {
                foreach ($rules as $rule) {
                    $rule->execute($e);
                }
            });
        }
    }
}
