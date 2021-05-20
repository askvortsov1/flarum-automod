<?php

namespace Askvortsov\AutoModerator\Action;

use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

interface ActionDriverInterface
{
    /**
     * A translation key for a human-readable name for this metric driver.
     */
    public function translationKey(): string;
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
     * Apply the action to the user.
     */
    public function execute(User $user, array $settings = [], User $lastEditedBy );
}