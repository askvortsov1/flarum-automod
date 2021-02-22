<?php

namespace Askvortsov\TrustLevels\Metric;

use Flarum\User\User as User;

interface MetricDriverInterface
{
    /**
     * A translation key for a human-readable name for this metric driver
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