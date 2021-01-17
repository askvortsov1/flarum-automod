<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\User\User;

class LikesGivenDriver implements RangeDriverInterface
{
    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.range_drivers.likes_given';
    }

    public function extensionDependencies(): array {
        return ['flarum-likes'];
    }

    public function getValue(User $user): int {
        return $user->join('post_likes', 'users.id', '=', 'post_likes.user_id')->count();
    }
}