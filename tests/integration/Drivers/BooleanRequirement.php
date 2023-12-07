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

use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

class BooleanRequirement implements RequirementDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'always_true';
    }

    public function translationKey(): string
    {
        return '';
    }

    public function availableSettings(): array
    {
        return [];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [])->errors();
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function subjectSatisfies(AbstractModel $user, array $settings ): bool
    {
        return true;
    }
}
