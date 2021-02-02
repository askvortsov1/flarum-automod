<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\Post\Post;
use Flarum\User\User;

class LikesReceivedDriver implements RangeDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-trust-levels.admin.range_drivers.likes_received';
    }

    public function extensionDependencies(): array
    {
        return ['flarum-likes'];
    }

    public function getValue(User $user): int
    {
        if (property_exists($user, 'clarkwinkelmann_likes_received_count')) {
            return $user->clarkwinkelmann_likes_received_count;
        }

        return Post::where('user_id', $user->id)->select('id')->withCount('likes')->get()->sum('likes_count');
    }
}
