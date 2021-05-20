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
use Askvortsov\AutoModerator\Action\Suspend;
use Carbon\Carbon;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;

class SuspendTest extends TestCase
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
    public function suspends_for_time()
    {
        /** @var ActionDriverInterface */
        $driver = $this->app()->getContainer()->make(Suspend::class);

        $driver->execute(User::find(2), ['days' => 3], User::find(1));

        $this->assertGreaterThan(Carbon::now()->addDays(2), User::find(2)->suspended_until);
        $this->assertLessThan(Carbon::now()->addDays(4), User::find(2)->suspended_until);
    }

    /**
     * @test
     */
    public function suspends_indefinitely()
    {
        /** @var ActionDriverInterface */
        $driver = $this->app()->getContainer()->make(Suspend::class);

        $driver->execute(User::find(2), ['indefinitely' => true], User::find(1));

        $this->assertGreaterThan(Carbon::now()->addDays(365 * 100 - 1), Carbon::parse(User::find(2)->suspended_until));
    }

    /**
     * @test
     */
    public function wont_shorten_suspension()
    {
        /** @var ActionDriverInterface */
        $driver = $this->app()->getContainer()->make(Suspend::class);

        $user = User::find(2);
        $user->suspended_until = Carbon::now()->addDays(100);
        $user->save();

        $driver->execute(User::find(2), ['days' => 5], User::find(1));

        $this->assertGreaterThan(Carbon::now()->addDays(99), Carbon::parse(User::find(2)->suspended_until));
    }
}
