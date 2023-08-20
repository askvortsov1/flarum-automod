<?php

namespace Askvortsov\AutoModerator;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

interface DriverInterface
{
    /**
     * A translation key for a human-readable name for this action driver.
     */
    public function translationKey(): string;

    /**
     * A list of Flarum extension IDs for extensions that should be enabled for this metric to be applied.
     */
    public function extensionDependencies(): array;
}
