<?php

namespace Askvortsov\TrustLevels\Metric;

use Flarum\User\User;

class PostsMadeDriver implements MetricDriverInterface
{
    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.metric_drivers.posts_made';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function getValue(User $user): int {
        return $user->comment_count;
    }
}