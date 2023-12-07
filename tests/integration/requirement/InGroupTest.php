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

use Askvortsov\AutoModerator\Requirement\Drivers\InGroup;
use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
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
        $driver = $this->app()->getContainer()->make(InGroup::class);

        $value = $driver->subjectSatisfies(User::find(1), ['group_id' => 1]);
        $this->assertEquals(true, $value);

        $value = $driver->subjectSatisfies(User::find(2), ['group_id' => 1]);
        $this->assertEquals(false, $value);
    }
}
