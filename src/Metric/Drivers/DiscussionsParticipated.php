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
use Flarum\Post\Event\Posted;
use Flarum\User\User;

/**
 * @implements MetricDriverInterface<User>
 */
class DiscussionsParticipated implements MetricDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'discussions_participated';
    }
    public function translationKey(): string
    {
        return 'askvortsov-automod.admin.metric_drivers.discussions_participated';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function getValue(AbstractModel $user): int
    {
        return $user->posts()
                    ->where('type', 'comment')
                    ->where('is_private', false)
                    ->distinct()->count('discussion_id');
    }
}
