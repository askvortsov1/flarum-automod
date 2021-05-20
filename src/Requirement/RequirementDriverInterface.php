<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Requirement;

use Flarum\User\User as User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

interface RequirementDriverInterface
{
    /**
     * A translation key for a human-readable name for this requirement driver.
     */
    public function translationKey(): string;

    /**
     * A list of settings used by this action.
     * 
     * Keys should be setting names, values should be translation keys for placeholders.
     */
    public function availableSettings(): array;

    /**
     * Validate provided settings.
     */
    public function validateSettings(array $settings, Factory $validator): MessageBag;

    /**
     * A list of Flarum extension IDs for extensions that should be enabled for this metric to be applied.
     */
    public function extensionDependencies(): array;

    /**
     * A list of events that cause criteria using this event to be reevaluated.
     * 
     * The keys should be event class names, and the values should be functions that take the event,
     * and return the user affected by the event.
     * 
     * `LoggedIn` is automatically a trigger for all criteria.
     */
    public function eventTriggers(): array;

    /**
     * Does the given user satisfy the requirement?
     */
    public function userSatisfies(User $user, array $settings = []): bool;
}
