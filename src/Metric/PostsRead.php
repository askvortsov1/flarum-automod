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

class PostsRead implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.metric_drivers.posts_read';
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
        // Find all read posts
        // Count read post by last read post number
        return $user->read()->sum('last_read_post_number');
    }
}
