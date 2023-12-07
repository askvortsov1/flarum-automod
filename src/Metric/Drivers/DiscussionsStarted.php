<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Metric;

use Flarum\Post\Event\Posted;
use Flarum\User\User;

class DiscussionsStarted implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.metric_drivers.discussions_started';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function eventTriggers(): array
    {
        return [
            Posted::class => function (Posted $event) {
                return $event->post->user;
            }
        ];
    }

    public function getValue(User $user): int
    {
        return intval($user->discussion_count);
    }
}
