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

use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

class BooleanRequirementWithSetting implements RequirementDriverInterface
{

    public function translationKey(): string
    {
        return '';
    }

    public function availableSettings(): array
    {
        return [
            'number' => ''
        ];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [
            'number' => 'required|integer',
        ])->errors();
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function eventTriggers(): array
    {
        return [];
    }

    public function userSatisfies(User $user, array $settings = []): bool
    {
        return true;
    }
}
