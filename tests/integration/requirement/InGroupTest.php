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

use Askvortsov\AutoModerator\Requirement\InGroup;
use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\GroupsChanged;
use Flarum\User\User;

class InGroupTest extends TestCase
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
    public function gets_user_properly_from_groups_changed_event()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(InGroup::class);

        $event = new GroupsChanged(User::find(2), []);
        $user = $driver->eventTriggers()[GroupsChanged::class]($event);

        $this->assertEquals(2, $user->id);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(InGroup::class);

        $value = $driver->userSatisfies(User::find(1), ['group_id' => 1]);
        $this->assertEquals(true, $value);

        $value = $driver->userSatisfies(User::find(2), ['group_id' => 1]);
        $this->assertEquals(false, $value);
    }
}
