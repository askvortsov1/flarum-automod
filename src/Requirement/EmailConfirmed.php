<?php

namespace Askvortsov\AutoModerator\Requirement;

use Flarum\User\Event\Activated;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

class EmailConfirmed implements RequirementDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-auto-moderator.admin.requirement_drivers.email_confirmed';
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
        return [];
    }

    public function eventTriggers(): array {
        return [
            Activated::class => function (Activated $event) {
                return $event->user;
            }
        ];
    }

    public function userSatisfies(User $user, array $settings = []): bool {
        return boolval($user->is_email_confirmed);
    }
}