<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Metric\Drivers;

use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\User;
use FoF\BestAnswer\Events\BestAnswerSet;

/**
 * @implements MetricDriverInterface<User>
 */
class BestAnswers implements MetricDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'best_answers';
    }

    public function extensionDependencies(): array
    {
        return ['fof-best-answer'];
    }

    public function translationKey(): string
    {
        return 'askvortsov-automod.admin.metric_drivers.best_answers';
    }

    public function getValue(AbstractModel $user): int
    {
        return $user->posts()->join('discussions', 'discussions.best_answer_post_id', '=', 'posts.id')
            ->count();
    }
}
