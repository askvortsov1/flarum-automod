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

use Flarum\Likes\Event\PostWasLiked;
use Flarum\Likes\Event\PostWasUnliked;
use Flarum\User\User;

class LikesGiven implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.metric_drivers.likes_given';
    }

    public function extensionDependencies(): array
    {
        return ['flarum-likes'];
    }

    public function eventTriggers(): array
    {
        return [
            PostWasLiked::class => function (PostWasLiked $event) {
                return $event->user;
            },
            PostWasUnliked::class => function (PostWasUnliked $event) {
                return $event->user;
            },
        ];
    }

    public function getValue(User $user): int
    {
        return $user->join('post_likes', 'users.id', '=', 'post_likes.user_id')->where('users.id', $user->id)->count();
    }
}
