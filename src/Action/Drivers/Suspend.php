<?php

namespace Askvortsov\AutoModerator\Action\Drivers;

use Askvortsov\AutoModerator\Action\ActionDriverInterface;
use Carbon\Carbon;
use Flarum\Database\AbstractModel;
use Flarum\Suspend\Event\Suspended;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Support\MessageBag;
use Flarum\User\User;
use Illuminate\Support\Arr;

/**
 * @implements ActionDriverInterface<User>
 */
class Suspend implements ActionDriverInterface
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
        return 'askvortsov-automod.admin.action_drivers.suspend';
    }

    public function availableSettings(): array
    {
        return [
            'days' => '',
            'indefinitely' => ''
        ];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [
            'days' => 'required_without:indefinitely|integer',
            'indefinitely' => 'required_without:days|boolean',
        ])->errors();
    }

    public function execute(AbstractModel $user, array $settings , User $lastEditedBy )
    {
        $days = Arr::get($settings, 'indefinitely', false) ? 365 * 100 : $settings['days'];

        /** @phpstan-ignore-next-line */
        $user->suspended_until = max(Carbon::now()->addDays($days), $user->suspended_until);
        $user->save();

        resolve('events')->dispatch(new Suspended($user, $lastEditedBy));
    }
}
