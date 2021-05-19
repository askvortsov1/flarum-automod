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

use Askvortsov\AutoModerator\Requirement\EmailConfirmed;
use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\Activated;
use Flarum\User\User;

class EmailConfirmedTest extends TestCase
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
    public function gets_user_properly_from_activated_event()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(EmailConfirmed::class);

        $event = new Activated(User::find(2));
        $user = $driver->eventTriggers()[Activated::class]($event);

        $this->assertEquals(2, $user->id);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(EmailConfirmed::class);

        $value = $driver->userSatisfies(User::find(1));
        $this->assertEquals(true, $value);

        $user = User::find(2);
        $user->is_email_confirmed = false;
        $user->save();
        $value = $driver->userSatisfies(User::find(2));
        $this->assertEquals(false, $value);
    }
}
