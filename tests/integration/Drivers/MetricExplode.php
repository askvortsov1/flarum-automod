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
use Exception;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\LoggedOut;
use Flarum\User\User;

class MetricExplode implements MetricDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'test_metric_explode';
    }

    public function translationKey(): string
    {
        return '';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function getValue(AbstractModel $user): int
    {
        throw new Exception("Should have short-circuited!!!");
    }
}
