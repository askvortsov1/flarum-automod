<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\metric;

use Askvortsov\AutoModerator\Metric\ModeratorStrikes;
use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;

class ModeratorStrikesTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('fof-best-answer');
        $this->extension('askvortsov-moderator-warnings');

        $this->prepareDatabase([
            'users' => [
                $this->normalUser(),
            ],
            'warnings' => [
                ['id' => 1, 'user_id' => 2, 'strikes' => 0],
                ['id' => 2, 'user_id' => 2, 'strikes' => 1],
                ['id' => 3, 'user_id' => 2, 'strikes' => 5],
            ],
        ]);
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        /** @var MetricDriverInterface */
        $driver = $this->app()->getContainer()->make(ModeratorStrikes::class);

        $value = $driver->getValue(User::find(1));
        $this->assertEquals(0, $value);

        $value = $driver->getValue(User::find(2));
        $this->assertEquals(6, $value);
    }
}
