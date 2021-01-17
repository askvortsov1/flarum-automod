<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\User\User;

class DiscussionsEnteredDriver implements RangeDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.range_drivers.discussions_entered';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function getValue(User $user): int {
        return $user->read()->count();
    }
}