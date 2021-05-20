<?php

namespace Askvortsov\AutoModerator\Action;

use Flarum\User\Event\Activated;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Support\MessageBag;
use Flarum\User\User;

class ActivateEmail implements ActionDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.action_drivers.activate_email';
    }

    public function availableSettings(): array {
        return [];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag {
        return $validator->make($settings, [])->errors();
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function execute(User $user, array $settings = [], User $lastEditedBy ) {
        $user->is_email_confirmed = true;
        $user->save();

        resolve('events')->dispatch(new Activated($user));
    }
}