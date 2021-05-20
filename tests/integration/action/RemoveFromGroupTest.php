<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\action;

use Askvortsov\AutoModerator\Action\ActionDriverInterface;
use Askvortsov\AutoModerator\Action\RemoveFromGroup;
use Flarum\Group\Group;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Guest;
use Flarum\User\User;

class RemoveFromGroupTest extends TestCase
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
    public function removes_user_from_group()
    {
        $this->prepareDatabase([
            'group_user' => [
                ['group_id' => Group::MODERATOR_ID, 'user_id' => 2]
            ]
        ]);
        
        /** @var ActionDriverInterface */
        $driver = $this->app()->getContainer()->make(RemoveFromGroup::class);

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());

        $driver->execute(User::find(2), ['group_id' => 4], new Guest());

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function doesnt_do_anything_if_user_already_in_group()
    {
        /** @var ActionDriverInterface */
        $driver = $this->app()->getContainer()->make(RemoveFromGroup::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());

        $driver->execute(User::find(2), ['group_id' => 4], new Guest());

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }
}
