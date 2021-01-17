<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\User\User;

class PostsMadeDriver implements RangeDriverInterface
{
    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.range_drivers.posts_made';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function getValue(User $user): int {
        return $user->comment_count;
    }
}