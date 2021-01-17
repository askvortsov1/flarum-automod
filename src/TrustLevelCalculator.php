<?php

namespace Askvortsov\TrustLevels;

use Flarum\User\User;
use Illuminate\Support\Arr;

class TrustLevelCalculator
{
    public function recalculate(User $user)
    {
        $stats = $this->getUserStats($user);

        $prevLevels = $user->trustLevels->toArray();
        $currLevels = $this->getTrustLevelsForStats($stats);

        $user->trustLevels()->sync(Arr::pluck($currLevels, 'id'));

        $this->adjustUserGroups($user, $prevLevels, $currLevels);
    }

    protected function getUserStats(User $user)
    {
        return [
            'discussions_entered'        => $user->read()->count(),
            'discussions_started'        => $user->discussion_count,
            'discussions_participated'   => $user->posts()
                                                ->where('type', 'comment')
                                                ->where('is_private', false)
                                                ->select('discussion_id')
                                                ->distinct()->count(),
            'posts_made'                 => $user->comment_count,
        ];
    }

    protected function getTrustLevelsForStats($stats)
    {
        return TrustLevel::all()->filter(function($level) use ($stats) {
            foreach ($stats as $stat => $val) {
                $min = $level->{"min_$stat"};
                $max = $level->{"min_$stat"};
                $withinRange = ($min === -1 || $val >= $min) && ($max === -1 || $val <= $max);

                if (!$withinRange) {
                    return false;
                }
            }

            return true;
        })->toArray();
    }

    protected function adjustUserGroups($user, $prevLevels, $currLevels)
    {
        $removedLevels = array_diff($prevLevels, $currLevels);
        $removedGroupIds = Arr::pluck($removedLevels, 'group_id');

        $newLevels = array_diff($currLevels, $prevLevels);
        $newGroupIds = Arr::pluck($newLevels, 'group_id');

        $allGroupIds = Arr::pluck($user->groups()->select('id')->get()->toArray(), 'id');
        $allGroupIds = array_diff($allGroupIds, $removedGroupIds);
        $allGroupIds = array_unique(array_merge($allGroupIds, $newGroupIds));

        $user->groups()->sync($allGroupIds);
    }
}