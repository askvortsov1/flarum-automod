<?php

namespace Askvortsov\AutoModerator\Action;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Support\MessageBag;
use Flarum\User\User;

class RemoveFromGroup implements ActionDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.action_drivers.remove_from_group';
    }

    public function availableSettings(): array
    {
        return [
            'group_id' => 'askvortsov-auto-moderator.lib.group_id'
        ];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [
            'group_id' => 'required|integer',
        ])->errors();
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function execute(User $user, array $settings = [], User $lastEditedBy )
    {
        $user->groups()->detach($settings['group_id']);
    }
}
