<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\Suspend\Event\Suspended;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<Suspended>
 */
class UserSuspended implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return Suspended::class;
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
        return "user_suspended";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.user_suspended";
    }

    public function extensionDependencies(): array
    {
        return ["flarum-suspend"];
    }
}
