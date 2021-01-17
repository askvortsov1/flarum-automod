<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\User\User;

class DiscussionsParticipatedDriver implements RangeDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.range_drivers.discussions_participated';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function getValue(User $user): int {
        return $user->posts()
                    ->where('type', 'comment')
                    ->where('is_private', false)
                    ->select('discussion_id')
                    ->distinct()->count();
    }
}