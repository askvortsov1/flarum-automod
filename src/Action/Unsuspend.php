<?php

namespace Askvortsov\AutoModerator\Action;

use Flarum\Suspend\Event\Unsuspended;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Support\MessageBag;
use Flarum\User\User;

class Unsuspend implements ActionDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.action_drivers.unsuspend';
    }

    public function availableSettings(): array
    {
        return [];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [])->errors();
    }

    public function extensionDependencies(): array
    {
        return ['flarum-suspend'];
    }

    public function execute(User $user, array $settings = [], User $lastEditedBy )
    {
        $user->suspended_until = null;
        $user->save();

        resolve('events')->dispatch(new Unsuspended($user, $lastEditedBy));
    }
}
