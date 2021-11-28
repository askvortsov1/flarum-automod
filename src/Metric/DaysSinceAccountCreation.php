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

use Flarum\User\User;

class DaysSinceAccountCreation implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.metric_drivers.days_since_account_creation';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function eventTriggers(): array
    {
        return [];
    }

    public function getValue(User $user): int
    {
        return (new \DateTime())->diff($user->joined_at)->format("%a");
    }
}
