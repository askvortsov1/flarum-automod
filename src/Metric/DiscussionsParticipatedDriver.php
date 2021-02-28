<?php

/*
 * This file is part of askvortsov/flarum-trust-levels
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Metric;

use Flarum\User\User;

class DiscussionsParticipatedDriver implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-trust-levels.admin.metric_drivers.discussions_participated';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function getValue(User $user): int
    {
        return $user->posts()
                    ->where('type', 'comment')
                    ->where('is_private', false)
                    ->distinct()->count('discussion_id');
    }
}
