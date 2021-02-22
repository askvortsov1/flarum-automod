<?php

namespace Askvortsov\TrustLevels\Metric;

use Flarum\User\User;

class DiscussionsStartedDriver implements MetricDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.metric_drivers.discussions_started';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function getValue(User $user): int {
        return $user->discussion_count;
    }
}