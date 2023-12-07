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

use Askvortsov\AutoModerator\Requirement\Drivers\EmailMatchesRegex;
use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
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
        $driver = $this->app()->getContainer()->make(EmailMatchesRegex::class);

        $value = $driver->subjectSatisfies(User::find(1), ['regex' => '^n.*@machine.local$']);
        $this->assertEquals(false, $value);

        $value = $driver->subjectSatisfies(User::find(2), ['regex' => '^n.*@machine.local$']);
        $this->assertEquals(true, $value);
    }
}
