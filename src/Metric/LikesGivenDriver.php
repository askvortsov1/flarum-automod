<?php

namespace Askvortsov\TrustLevels\Metric;

use Flarum\User\User;

class LikesGivenDriver implements MetricDriverInterface
{
    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.metric_drivers.likes_given';
    }

    public function extensionDependencies(): array {
        return ['flarum-likes'];
    }

    public function getValue(User $user): int {
        return $user->join('post_likes', 'users.id', '=', 'post_likes.user_id')->count();
    }
}