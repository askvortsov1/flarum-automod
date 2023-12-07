<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\Activated;
use Flarum\User\Event\Registered;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<Activated>
 */
class UserActivated implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return Activated::class;
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
        return "user_activated";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.user_activated";
    }

    public function extensionDependencies(): array
    {
        return [];
    }
}
