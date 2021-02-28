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
     * Get the current value of this metric for a given user.
     */
    public function getValue(User $user): int;
}
