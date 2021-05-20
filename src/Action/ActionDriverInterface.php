<?php

namespace Askvortsov\AutoModerator\Action;

use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

interface ActionDriverInterface
{
    /**
     * A translation key for a human-readable name for this action driver.
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
     * Apply the action to the user.
     * Don't forget to dispatch any events that should be emitted!
     */
    public function execute(User $user, array $settings = [], User $lastEditedBy);
}