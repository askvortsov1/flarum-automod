<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\Saving;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<Saving>
 */
class UserSaving implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return Saving::class;
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
        return "user_saving";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.user_saving";
    }

    public function extensionDependencies(): array
    {
        return [];
    }
}
