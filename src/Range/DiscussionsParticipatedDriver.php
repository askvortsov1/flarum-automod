<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\User\User;

class DiscussionsParticipatedDriver implements RangeDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-trust-levels.admin.trust_level_modal.ranges.discussions_participated_label';
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