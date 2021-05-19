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

use Flarum\Discussion\Event\UserRead;
use Flarum\User\User;

class DiscussionsEntered implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.metric_drivers.discussions_entered';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function eventTriggers(): array
    {
        return [
            UserRead::class => function (UserRead $event) {
                return $event->state->user;
            }
        ];
    }

    public function getValue(User $user): int
    {
        return $user->read()->count();
    }
}
