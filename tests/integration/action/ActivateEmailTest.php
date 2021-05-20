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
use Askvortsov\AutoModerator\Action\ActivateEmail;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Guest;
use Flarum\User\User;

class ActivateEmailTest extends TestCase
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
    public function confirms_email()
    {
        /** @var ActionDriverInterface */
        $driver = $this->app()->getContainer()->make(ActivateEmail::class);

        $user = User::find(2);
        $user->is_email_confirmed = false;
        $user->save();

        $driver->execute(User::find(2), [], new Guest());

        $this->assertEquals(1, User::find(2)->is_email_confirmed);
    }

    /**
     * @test
     */
    public function doesnt_do_anything_if_email_already_confirmed()
    {
        /** @var ActionDriverInterface */
        $driver = $this->app()->getContainer()->make(ActivateEmail::class);

        $this->assertEquals(1, User::find(2)->is_email_confirmed);

        $driver->execute(User::find(2), [], new Guest());

        $this->assertEquals(1, User::find(2)->is_email_confirmed);
    }
}
