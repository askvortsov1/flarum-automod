<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\criteria;

use Askvortsov\AutoModerator\Tests\integration\metric\UsesMetric;
use Carbon\Carbon;
use Flarum\Http\AccessToken;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;

class SettingsInvalidTest extends TestCase
{
    use RetrievesAuthorizedUsers;
    use UsesMetric;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('askvortsov-auto-moderator');

        $this->prepareDatabase([
            'users' => [
                $this->normalUser(),
            ],
            'discussions' => [
                ['id' => 1, 'title' => __CLASS__, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 2, 'title' => __CLASS__, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 3, 'title' => __CLASS__, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 4, 'title' => __CLASS__, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 5, 'title' => __CLASS__, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
            ],
            'discussion_user' => [
                ['discussion_id' => 1, 'user_id' => 2, 'last_read_at' => Carbon::now()->toDateTimeString()],
                ['discussion_id' => 2, 'user_id' => 2, 'last_read_at' => Carbon::now()->toDateTimeString()],
                ['discussion_id' => 3, 'user_id' => 2, 'last_read_at' => Carbon::now()->toDateTimeString()],
            ],
            'posts' => [
                ['id' => 1, 'discussion_id' => 1, 'created_at' => Carbon::now()->toDateTimeString(), 'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
            ],
        ]);
    }

    /**
     * @test
     */
    public function not_added_to_group_if_settings_invalid()
    {
        $this->prepareDatabase(['criteria' => [
            $this->genCriterion('discussions entered', '', [
                'discussions_entered' => [2, 10],
            ]),
        ]]);

        $this->app();
        User::find(2)->refreshCommentCount()->save();
        $this->app()->getContainer()->make('events')->dispatch(new LoggedIn(User::find(2), new AccessToken([])));

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }
}
