<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\User\User;

class DiscussionsStartedDriver implements RangeDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.range_drivers.discussions_started';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function getValue(User $user): int {
        return $user->discussion_count;
    }
}