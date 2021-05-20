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
use Askvortsov\AutoModerator\Action\Unsuspend;
use Carbon\Carbon;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;

class UnsuspendTest extends TestCase
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
    public function unsuspends_properly()
    {
        /** @var ActionDriverInterface */
        $driver = $this->app()->getContainer()->make(Unsuspend::class);

        $user = User::find(2);
        $user->suspended_until = Carbon::now()->addDays(100);
        $user->save();

        $driver->execute(User::find(2), [], User::find(1));

        $this->assertNull(User::find(2)->suspended_until);
    }

    /**
     * @test
     */
    public function no_effect_on_unsuspended_user()
    {
        /** @var ActionDriverInterface */
        $driver = $this->app()->getContainer()->make(Unsuspend::class);

        $this->assertNull(User::find(2)->suspended_until);

        $driver->execute(User::find(2), [], User::find(1));

        $this->assertNull(User::find(2)->suspended_until);
    }
}
