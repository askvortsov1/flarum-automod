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
use Flarum\Post\Post;
use Flarum\User\User;

class LikesReceived implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.metric_drivers.likes_received';
    }

    public function extensionDependencies(): array
    {
        return ['flarum-likes'];
    }

    public function eventTriggers(): array
    {
        return [
            PostWasLiked::class => function (PostWasLiked $event) {
                return $event->post->user;
            },
            PostWasUnliked::class => function (PostWasUnliked $event) {
                return $event->post->user;
            },
        ];
    }

    public function getValue(User $user): int
    {
        if (property_exists($user, 'clarkwinkelmann_likes_received_count')) {
            return intval($user->clarkwinkelmann_likes_received_count);
        }

        return Post::where('user_id', $user->id)->select('id')->withCount('likes')->get()->sum('likes_count');
    }
}
