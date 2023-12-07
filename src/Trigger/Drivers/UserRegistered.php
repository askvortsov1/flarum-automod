<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\Registered;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<Registered>
 */
class UserRegistered implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return Registered::class;
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
        return "user_registered";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.user_registered";
    }

    public function extensionDependencies(): array
    {
        return [];
    }
}
