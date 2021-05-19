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

use Askvortsov\FlarumWarnings\Model\Warning;
use Flarum\User\User;

class ModeratorStrikes implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.metric_drivers.moderator_strikes';
    }

    public function extensionDependencies(): array
    {
        return ['askvortsov-moderator-warnings'];
    }

    public function eventTriggers(): array
    {
        // Ext doesnt currently have events
        return [];
    }

    public function getValue(User $user): int
    {
        return Warning::where('user_id', $user->id)->sum('strikes');
    }
}
