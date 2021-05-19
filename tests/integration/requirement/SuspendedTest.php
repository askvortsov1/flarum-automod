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

use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Askvortsov\AutoModerator\Requirement\Suspended;
use Carbon\Carbon;
use Flarum\Suspend\Event;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;

class SuspendedTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('flarum-suspend');
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
    public function gets_user_properly_from_suspended_event()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(Suspended::class);

        $event = new Event\Suspended(User::find(2), User::find(1));
        $user = $driver->eventTriggers()[Event\Suspended::class]($event);

        $this->assertEquals(2, $user->id);
    }

    /**
     * @test
     */
    public function gets_user_properly_from_unsuspended_event()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(Suspended::class);

        $event = new Event\Unsuspended(User::find(2), User::find(1));
        $user = $driver->eventTriggers()[Event\Unsuspended::class]($event);

        $this->assertEquals(2, $user->id);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(Suspended::class);

        $value = $driver->userSatisfies(User::find(1));
        $this->assertEquals(false, $value);

        $user = User::find(2);
        $user->suspended_until = Carbon::createFromDate(3000, 1, 1)->toDateString();
        $user->save();
        $value = $driver->userSatisfies(User::find(2));
        $this->assertEquals(true, $value);
    }
}
