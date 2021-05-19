<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\criteria\Drivers;

use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Flarum\User\Event\LoggedOut;
use Flarum\User\User;

class MetricReturn15 implements MetricDriverInterface
{

    public function translationKey(): string
    {
        return '';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function eventTriggers(): array
    {
        return [LoggedOut::class => function (LoggedOut $event) {
            return $event->user;
        }];
    }

    public function getValue(User $user): int
    {
        return 15;
    }
}
