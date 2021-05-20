<?php

namespace Askvortsov\AutoModerator\Requirement;

use Flarum\Suspend\Event;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

class Suspended implements RequirementDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-auto-moderator.admin.requirement_drivers.suspended';
    }

    public function availableSettings(): array
    {
        return [];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [])->errors();
    }

    public function extensionDependencies(): array {
        return ['flarum-suspend'];
    }

    public function eventTriggers(): array {
        return [
            Event\Suspended::class => function (Event\Suspended $event) {
                return $event->user;
            },
            Event\Unsuspended::class => function (Event\Unsuspended $event) {
                return $event->user;
            }
        ];
    }

    public function userSatisfies(User $user, array $settings = []): bool {
        return $user->suspended_until !== null;
    }
}