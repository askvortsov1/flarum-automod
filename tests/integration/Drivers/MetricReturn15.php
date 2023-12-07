<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\Drivers;

use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\LoggedOut;
use Flarum\User\User;

class MetricReturn15 implements MetricDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'test_metric_15';
    }

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

    public function getValue(AbstractModel $user): int
    {
        return 15;
    }
}
