<?php

namespace Askvortsov\TrustLevels\Range;

use Flarum\User\User as User;

interface RangeDriverInterface
{
    /**
     * A translation key for a human-readable name for this range driver
     */
    public function translationKey(): string;

    /**
     * A list of Flarum extension IDs for extensions that should be enabled for this range to be applied.
     */
    public function extensionDependencies(): array;

    /**
     * Get the current value of this range for a given user.
     */
    public function getValue(User $user): int;
}