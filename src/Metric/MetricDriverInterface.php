<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Metric;

use Flarum\User\User as User;

interface MetricDriverInterface
{
    /**
     * A translation key for a human-readable name for this metric driver.
     */
    public function translationKey(): string;

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
     * Get the current value of this metric for a given user.
     */
    public function getValue(User $user): int;
}
