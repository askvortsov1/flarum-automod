<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\Activated;
use Flarum\User\Event\GroupsChanged;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<GroupsChanged>
 */
class UserGroupsChanged implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return GroupsChanged::class;
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
        return "user_groups_changed";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.user_groups_changed";
    }

    public function extensionDependencies(): array
    {
        return [];
    }
}
