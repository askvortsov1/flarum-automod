<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\User\User;

class PostsMadeDriver implements RangeDriverInterface
{
    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.trust_level_modal.ranges.posts_made_label';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function getValue(User $user): int {
        return $user->comment_count;
    }
}