<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\Suspend\Event\Unsuspended;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<Unsuspended>
 */
class UserUnsuspended implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return Unsuspended::class;
    }

    public function subjectClasses(): array
    {
        return [User::class];
    }

    public function getSubject(string $subjectClass, mixed $event): AbstractModel
    {
        return $event->user;
    }

    public function id(): string
    {
        return "user_unsuspended";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.user_unsuspended";
    }

    public function extensionDependencies(): array
    {
        return ["flarum-suspend"];
    }
}
