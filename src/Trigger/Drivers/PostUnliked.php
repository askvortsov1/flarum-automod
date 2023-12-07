<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\Likes\Event\PostWasUnliked;
use Flarum\Post\Event\Unliked;
use Flarum\Post\Post;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<Unliked>
 */
class PostUnliked implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return PostWasUnliked::class;
    }

    public function subjectClasses(): array
    {
        return [Post::class, User::class];
    }

    public function getSubject(string $subjectClass, mixed $event): AbstractModel
    {
        switch ($subjectClass) {
            case Post::class:
                return $event->post;
            case User::class:
                return $event->user;
        }
    }

    public function id(): string
    {
        return "post_unliked";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.post_unliked";
    }

    public function extensionDependencies(): array
    {
        return ['flarum-likes'];
    }
}
