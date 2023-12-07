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
use Askvortsov\FlarumWarnings\Model\Warning;
use Flarum\Database\AbstractModel;
use Flarum\User\User;

/**
 * @implements MetricDriverInterface<User>
 */
class ModeratorStrikes implements MetricDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'moderator_strikes';
    }

    public function translationKey(): string
    {
        return 'askvortsov-automod.admin.metric_drivers.moderator_strikes';
    }

    public function extensionDependencies(): array
    {
        return ['askvortsov-moderator-warnings'];
    }

    public function getValue(AbstractModel $user): int
    {
        return Warning::where('user_id', $user->id)->sum('strikes');
    }
}
