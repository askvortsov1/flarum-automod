<?php

namespace Askvortsov\AutoModerator;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

interface DriverWithSettingsInterface extends DriverInterface
{
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
}
