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

use Askvortsov\AutoModerator\Metric\BestAnswers;
use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Carbon\Carbon;
use Flarum\Discussion\Discussion;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;
use FoF\BestAnswer\Events\BestAnswerSet;

class BestAnswersTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('fof-best-answer');
        $this->extension('askvortsov-auto-moderator');

        $this->prepareDatabase([
            'users' => [
                $this->normalUser(),
            ],
            'discussions' => [
                ['id' => 1, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1, 'best_answer_user_id' => 2, 'best_answer_post_id' => 1],
                ['id' => 2, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1, 'best_answer_user_id' => 2, 'best_answer_post_id' => 7],
                ['id' => 3, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1, 'best_answer_user_id' => 2, 'best_answer_post_id' => 8],
                ['id' => 4, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1, 'best_answer_user_id' => 2, 'best_answer_post_id' => 9],
                ['id' => 5, 'title' => __CLASS__,  'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1, 'best_answer_user_id' => 2, 'best_answer_post_id' => 10],
            ],
            'posts' => [
                ['id' => 1, 'discussion_id' => 1,  'user_id' => 1, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 6, 'discussion_id' => 1,  'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 7, 'discussion_id' => 2,  'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 8, 'discussion_id' => 3,  'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 9, 'discussion_id' => 4,  'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
                ['id' => 10, 'discussion_id' => 5,  'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>foo bar</p></t>'],
            ],
        ]);
    }

    /**
     * @test
     */
    public function gets_user_properly_from_best_answer_set_event()
    {
        /** @var MetricDriverInterface */
        $driver = $this->app()->getContainer()->make(BestAnswers::class);

        $event = new BestAnswerSet(Discussion::find(1), User::find(2));
        $user = $driver->eventTriggers()[BestAnswerSet::class]($event);

        $this->assertEquals(2, $user->id);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var MetricDriverInterface */
        $driver = $this->app()->getContainer()->make(BestAnswers::class);

        $value = $driver->getValue(User::find(1));
        $this->assertEquals(1, $value);

        $value = $driver->getValue(User::find(2));
        $this->assertEquals(4, $value);
    }
}
