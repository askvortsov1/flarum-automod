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

use Carbon\Carbon;
use Flarum\Http\AccessToken;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;

class LikesGivenTest extends TestCase
{
    use RetrievesAuthorizedUsers;
    use UsesMetric;

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
                ['id' => 1, 'title' => __CLASS__, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 1, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 2, 'title' => __CLASS__, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 1, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 3, 'title' => __CLASS__, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
            ],
            'posts' => [
                ['id' => 1, 'discussion_id' => 1, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 1, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],

                ['id' => 2, 'discussion_id' => 1, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 3, 'discussion_id' => 2, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 1, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 4, 'discussion_id' => 3, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 1, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 5, 'discussion_id' => 3, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
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
    public function not_added_to_group_by_default()
    {
        $this->app()->getContainer()->make('events')->dispatch(new LoggedIn(User::find(2), new AccessToken([])));

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function added_to_group_properly()
    {
        $this->prepareDatabase(['criteria' => [
            $this->genCriterion('likes given', 4, [
                'likes_given' => [2, 10],
            ]),
        ]]);

        $this->app();
        User::find(2)->refreshCommentCount()->save();
        $this->app()->getContainer()->make('events')->dispatch(new LoggedIn(User::find(2), new AccessToken([])));

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_added_to_group_if_doesnt_apply()
    {
        $this->prepareDatabase(['criteria' => [
            $this->genCriterion('likes given', 4, [
                'likes_given' => [-1, 4],
            ]),
            $this->genCriterion('likes given', 4, [
                'likes_given' => [1, 4],
            ]),
            $this->genCriterion('likes given', 4, [
                'likes_given' => [6, 100],
            ]),
            $this->genCriterion('likes given', 4, [
                'likes_given' => [6, -1],
            ]),
        ]]);

        $this->app();
        User::find(2)->refreshCommentCount()->save();
        $this->app()->getContainer()->make('events')->dispatch(new LoggedIn(User::find(2), new AccessToken([])));

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }
}
