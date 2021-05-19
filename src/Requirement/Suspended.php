<?php

namespace Askvortsov\AutoModerator\Requirement;

use Flarum\Suspend\Event;
use Flarum\Suspend\Event\Unsuspended;
use Flarum\User\Event\Activated;
use Flarum\User\User;

class Suspended implements RequirementDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-auto-moderator.admin.requirement_drivers.suspended';
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

    public function userSatisfies(User $user): bool {
        return $user->suspended_until !== null;
    }
}