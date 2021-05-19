<?php

namespace Askvortsov\AutoModerator\Action;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Support\MessageBag;
use Flarum\User\User;

class AddToGroup implements ActionDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.action_drivers.add_to_group';
    }

    public function availableSettings(): array {
        return [
            'group_id' => 'askvortsov-auto-moderator.lib.group_id'
        ];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag {
        return $validator->make($settings, [
            'group_id' => 'required|integer',
        ])->errors();
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function execute(User $user, array $settings) {
        $user->groups()->attach($settings['group_id']);
    }

}