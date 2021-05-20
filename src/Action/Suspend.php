<?php

namespace Askvortsov\AutoModerator\Action;

use Carbon\Carbon;
use Flarum\Suspend\Event\Suspended;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Support\MessageBag;
use Flarum\User\User;
use Illuminate\Support\Arr;

class Suspend implements ActionDriverInterface
{
    public function translationKey(): string
    {
        return 'askvortsov-auto-moderator.admin.action_drivers.suspend';
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

    public function extensionDependencies(): array
    {
        return ['flarum-suspend'];
    }

    public function execute(User $user, array $settings = [], User $lastEditedBy )
    {
        $days = Arr::get($settings, 'indefinitely', false) ? 365 * 100 : $settings['days'];

        $user->suspended_until = max(Carbon::now()->addDays($days), $user->suspended_until);
        $user->save();

        resolve('events')->dispatch(new Suspended($user, $lastEditedBy));
    }
}
