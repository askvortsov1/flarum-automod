<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\Discussion\Discussion;
use Flarum\Post\Event\Started;
use Flarum\Post\Event\Registered;
use Flarum\Post\Post;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<Started>
 */
class DiscussionStarted implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return Started::class;
    }

    public function subjectClasses(): array
    {
        return [Discussion::class, Post::class, User::class];
    }

    public function getSubject(string $subjectClass, mixed $event): AbstractModel
    {
        switch ($subjectClass) {
            case Discussion::class:
                return $event->discussion;
            case Post::class:
                return $event->discussion->firstPost;
            case User::class:
                return $event->user;
        }
    }

    public function id(): string
    {
        return "discussion_started";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.discussion_started";
    }

    public function extensionDependencies(): array
    {
        return [];
    }
}
