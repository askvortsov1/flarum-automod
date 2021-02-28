<?php

/*
 * This file is part of askvortsov/flarum-trust-levels
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Metric;

use Flarum\Discussion\Discussion;
use Flarum\User\User;

class BestAnswersDriver implements MetricDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-trust-levels.admin.metric_drivers.best_answers';
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
