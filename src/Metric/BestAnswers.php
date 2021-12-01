<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Metric;

use Flarum\Discussion\Discussion;
use Flarum\User\User;
use FoF\BestAnswer\Events\BestAnswerSet;

class BestAnswers implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.metric_drivers.best_answers';
    }

    public function extensionDependencies(): array
    {
        return ['fof-best-answer'];
    }

    public function eventTriggers(): array
    {
        // Best answer unset isn't included because it doesn't contain the best answer user.
        return [
            BestAnswerSet::class => function (BestAnswerSet $event) {
                return $event->discussion->bestAnswerUser;
            }
        ];
    }

    public function getValue(User $user): int
    {
        return $user->posts()->join('discussions', 'discussions.best_answer_post_id', '=', 'posts.id')
            ->count();
    }
}
