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

use Askvortsov\AutoModerator\Metric\DiscussionsEntered;
use Carbon\Carbon;
use Flarum\Discussion\Event\UserRead;
use Flarum\Discussion\UserState;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;

class DiscussionsEnteredTest extends TestCase
{
    use RetrievesAuthorizedUsers;

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
                ['id' => 1, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 2, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
                ['id' => 3, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1],
            ],
            'discussion_user' => [
                ['discussion_id' => 1, 'user_id' => 2],
                ['discussion_id' => 2, 'user_id' => 2]
            ],
        ]);
    }

    /**
     * @test
     */
    public function gets_user_properly_from_user_read_event()
    {
        /** @var MetricDriverInterface */
        $driver = $this->app()->getContainer()->make(DiscussionsEntered::class);

        $state = new UserState();
        $state->user = User::find(2);
        $event = new UserRead($state);
        $user = $driver->eventTriggers()[UserRead::class]($event);

        $this->assertEquals(2, $user->id);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var MetricDriverInterface */
        $driver = $this->app()->getContainer()->make(DiscussionsEntered::class);

        $value = $driver->getValue(User::find(1));
        $this->assertEquals(0, $value);

        $value = $driver->getValue(User::find(2));
        $this->assertEquals(2, $value);
    }
}
