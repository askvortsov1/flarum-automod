<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\requirement;

use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Askvortsov\AutoModerator\Requirement\Drivers\Suspended;
use Carbon\Carbon;
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
        $this->extension('askvortsov-automod');

        $this->prepareDatabase([
            'users' => [
                $this->normalUser(),
            ]
        ]);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var RequirementDriverInterface */
        $driver = $this->app()->getContainer()->make(Suspended::class);

        $value = $driver->subjectSatisfies(User::find(1), []);
        $this->assertEquals(false, $value);

        $user = User::find(2);
        $user->suspended_until = Carbon::createFromDate(3000, 1, 1)->toDateString();
        $user->save();
        $value = $driver->subjectSatisfies(User::find(2), []);
        $this->assertEquals(true, $value);
    }
}
