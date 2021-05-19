<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\metric;

use Askvortsov\AutoModerator\Metric\LikesGiven;
use Carbon\Carbon;
use Flarum\Likes\Event\PostWasLiked;
use Flarum\Likes\Event\PostWasUnliked;
use Flarum\Post\Post;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;

class LikesGivenTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('flarum-likes');
        $this->extension('askvortsov-auto-moderator');

        $this->prepareDatabase([
            'users' => [
                $this->normalUser(),
            ],
            'discussions' => [
                ['id' => 1, 'title' => __CLASS__,  'user_id' => 1, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 2, 'title' => __CLASS__,  'user_id' => 1, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 3, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
            ],
            'posts' => [
                ['id' => 1, 'discussion_id' => 1,  'user_id' => 1, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],

                ['id' => 2, 'discussion_id' => 1,  'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 3, 'discussion_id' => 2,  'user_id' => 1, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 4, 'discussion_id' => 3,  'user_id' => 1, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 5, 'discussion_id' => 3,  'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
            ],
            'post_likes' => [
                ['post_id' => 1, 'user_id' => 2],
                ['post_id' => 2, 'user_id' => 2],
                ['post_id' => 3, 'user_id' => 2],
                ['post_id' => 4, 'user_id' => 2],
                ['post_id' => 5, 'user_id' => 2],
            ],
        ]);
    }

    /**
     * @test
     */
    public function gets_user_properly_from_post_was_liked_event()
    {
        /** @var MetricDriverInterface */
        $driver = $this->app()->getContainer()->make(LikesGiven::class);

        // 1st argument is a red herring: should use actor
        $event = new PostWasLiked(Post::find(1), User::find(2));
        $user = $driver->eventTriggers()[PostWasLiked::class]($event);

        $this->assertEquals(2, $user->id);
    }

    /**
     * @test
     */
    public function gets_user_properly_from_post_was_unliked_event()
    {
        /** @var MetricDriverInterface */
        $driver = $this->app()->getContainer()->make(LikesGiven::class);

        // 1st argument is a red herring: should use actor
        $event = new PostWasUnliked(Post::find(1), User::find(2));
        $user = $driver->eventTriggers()[PostWasUnliked::class]($event);

        $this->assertEquals(2, $user->id);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var MetricDriverInterface */
        $driver = $this->app()->getContainer()->make(LikesGiven::class);

        $value = $driver->getValue(User::find(1));
        $this->assertEquals(0, $value);

        $value = $driver->getValue(User::find(2));
        $this->assertEquals(5, $value);
    }
}
