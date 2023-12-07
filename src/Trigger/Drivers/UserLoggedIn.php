<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<LoggedIn>
 */
class UserLoggedIn implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return LoggedIn::class;
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
        return "user_logged_in";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.user_logged_in";
    }

    public function extensionDependencies(): array
    {
        return [];
    }
}
