<?php

namespace Askvortsov\AutoModerator\Requirement;

use Flarum\User\Event\Activated;
use Flarum\User\User;

class EmailConfirmed implements RequirementDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-auto-moderator.admin.requirement_drivers.email_confirmed';
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

    public function userSatisfies(User $user): bool {
        return boolval($user->is_email_confirmed);
    }
}