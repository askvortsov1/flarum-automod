<?php

namespace Askvortsov\AutoModerator\Action\Drivers;

use Askvortsov\AutoModerator\Action\ActionDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\Suspend\Event\Unsuspended;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Support\MessageBag;
use Flarum\User\User;

/**
 * @implements ActionDriverInterface<User>
 */
class Unsuspend implements ActionDriverInterface
{
    public function subject(): string
    {
        return User::class;
    }

    public function id(): string
    {
        return 'suspend';
    }

    public function extensionDependencies(): array
    {
        return ['flarum-suspend'];
    }

    public function translationKey(): string
    {
        return 'askvortsov-automod.admin.action_drivers.unsuspend';
    }

    public function availableSettings(): array
    {
        return [];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [])->errors();
    }
    public function execute(AbstractModel $user, array $settings , User $lastEditedBy )
    {
        /** @phpstan-ignore-next-line */
        $user->suspended_until = null;
        $user->save();

        resolve('events')->dispatch(new Unsuspended($user, $lastEditedBy));
    }
}
