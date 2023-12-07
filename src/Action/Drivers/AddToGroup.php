<?php

namespace Askvortsov\AutoModerator\Action\Drivers;

use Askvortsov\AutoModerator\Action\ActionDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\GroupsChanged;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Support\MessageBag;
use Flarum\User\User;

/**
 * @implements ActionDriverInterface<User>
 */
class AddToGroup implements ActionDriverInterface
{
    public function subject(): string
    {
        return User::class;
    }

    public function id(): string
    {
        return 'add_to_group';
    }

    public function translationKey(): string
    {
        return 'askvortsov-automod.admin.action_drivers.add_to_group';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function availableSettings(): array {
        return [
            'group_id' => 'askvortsov-automod.lib.group_id'
        ];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag {
        return $validator->make($settings, [
            'group_id' => 'required|integer',
        ])->errors();
    }

    public function execute(AbstractModel $user, array $settings, User $lastEditedBy ) {
        $groups = $user->groups->toArray();
        $user->groups()->syncWithoutDetaching([$settings['group_id']]);

        resolve('events')->dispatch(new GroupsChanged($user, $groups));
    }

}
