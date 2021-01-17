<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\User\User;

class DiscussionsStartedDriver implements RangeDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.trust_level_modal.ranges.discussions_started_label';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function getValue(User $user): int {
        return $user->discussion_count;
    }
}