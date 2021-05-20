<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\requirement;

use Askvortsov\AutoModerator\Requirement\EmailMatchesRegex;
use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\Saving;
use Flarum\User\Guest;
use Flarum\User\User;

class EmailMatchesRegexTest extends TestCase
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
            ]
        ]);
    }

    /**
     * @test
     */
    public function gets_user_properly_from_saving_event()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(EmailMatchesRegex::class);

        $event = new Saving(User::find(2), new Guest(), []);
        $user = $driver->eventTriggers()[Saving::class]($event);

        $this->assertEquals(2, $user->id);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(EmailMatchesRegex::class);

        $value = $driver->userSatisfies(User::find(1), ['regex' => '^n.*@machine.local$']);
        $this->assertEquals(false, $value);

        $value = $driver->userSatisfies(User::find(2), ['regex' => '^n.*@machine.local$']);
        $this->assertEquals(true, $value);
    }
}
