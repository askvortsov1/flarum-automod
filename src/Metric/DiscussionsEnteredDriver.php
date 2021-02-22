<?php

namespace Askvortsov\TrustLevels\Metric;

use Flarum\User\User;

class DiscussionsEnteredDriver implements MetricDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.metric_drivers.discussions_entered';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function getValue(User $user): int {
        return $user->read()->count();
    }
}