<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\metric;

use Askvortsov\AutoModerator\Metric\Drivers\PostsMade;
use Carbon\Carbon;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;

class PostsMadeTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('askvortsov-automod');

        $this->prepareDatabase([
            'users' => [
                $this->normalUser(),
            ],
            'discussions' => [
                ['id' => 1, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 2, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 3, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 4, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 5, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
            ],
            'discussion_user' => [
                ['discussion_id' => 1, 'user_id' => 2, 'last_read_at' => Carbon::now()->toDateTimeString()],
                ['discussion_id' => 2, 'user_id' => 2, 'last_read_at' => Carbon::now()->toDateTimeString()],
                ['discussion_id' => 3, 'user_id' => 2, 'last_read_at' => Carbon::now()->toDateTimeString()],
            ],
            'posts' => [
                ['id' => 1, 'discussion_id' => 1,  'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
            ],
        ]);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var MetricDriverInterface */
        $driver = $this->app()->getContainer()->make(PostsMade::class);

        User::find(1)->refreshCommentCount()->save();
        $value = $driver->getValue(User::find(1));
        $this->assertEquals(0, $value);

        User::find(2)->refreshCommentCount()->save();
        $value = $driver->getValue(User::find(2));
        $this->assertEquals(1, $value);
    }
}
