<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Metric\Drivers;

use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\Likes\Event\PostWasLiked;
use Flarum\Likes\Event\PostWasUnliked;
use Flarum\User\User;

/**
 * @implements MetricDriverInterface<User>
 */
class LikesGiven implements MetricDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'likes_given';
    }

    public function translationKey(): string
    {
        return 'askvortsov-automod.admin.metric_drivers.likes_given';
    }

    public function extensionDependencies(): array
    {
        return ['flarum-likes'];
    }

    public function getValue(AbstractModel $user): int
    {
        return $user->join('post_likes', 'users.id', '=', 'post_likes.user_id')->where('users.id', $user->id)->count();
    }
}
