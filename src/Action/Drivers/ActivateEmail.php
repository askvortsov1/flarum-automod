<?php

namespace Askvortsov\AutoModerator\Action\Drivers;

use Askvortsov\AutoModerator\Action\ActionDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\Activated;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Support\MessageBag;
use Flarum\User\User;

/**
 * @implements ActionDriverInterface<User>
 */
class ActivateEmail implements ActionDriverInterface
{
    public function subject(): string
    {
        return User::class;
    }

    public function id(): string
    {
        return 'activate_email';
    }

    public function translationKey(): string
    {
        return 'askvortsov-automod.admin.action_drivers.activate_email';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function availableSettings(): array {
        return [];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag {
        return $validator->make($settings, [])->errors();
    }

    public function execute(AbstractModel $user, array $settings, User $lastEditedBy ) {
        $user->is_email_confirmed = true;
        $user->save();

        resolve('events')->dispatch(new Activated($user));
    }
}
