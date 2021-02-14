<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\Discussion\Discussion;
use Flarum\User\User;

class BestAnswersDriver implements RangeDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-trust-levels.admin.range_drivers.best_answers';
    }

    public function extensionDependencies(): array
    {
        return ['fof-best-answer'];
    }

    public function getValue(User $user): int
    {
        return Discussion::where('best_answer_user_id', $user->id)->count();
    }
}
