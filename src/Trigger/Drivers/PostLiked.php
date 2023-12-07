<?php

use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\Likes\Event\PostWasLiked;
use Flarum\Post\Event\Liked;
use Flarum\Post\Post;
use Flarum\User\User;

/**
 * @implements TriggerDriverInterface<Liked>
 */
class PostLiked implements TriggerDriverInterface
{
    public function eventClass(): string
    {
        return PostWasLiked::class;
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
        return "post_liked";
    }

    public function translationKey(): string
    {
        return "askvortsov-automod.admin.trigger_drivers.post_liked";
    }

    public function extensionDependencies(): array
    {
        return ['flarum-likes'];
    }
}
