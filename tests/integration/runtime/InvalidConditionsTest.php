<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\runtime;

use Askvortsov\AutoModerator\CriteriaCalculator;
use Askvortsov\AutoModerator\Extend\AutoModerator;
use Askvortsov\AutoModerator\Tests\integration\Drivers\BooleanRequirement;
use Askvortsov\AutoModerator\Tests\integration\Drivers\BooleanRequirementWithSetting;
use Askvortsov\AutoModerator\Tests\integration\Drivers\MetricExplode;
use Askvortsov\AutoModerator\Tests\integration\Drivers\MetricReturn15;
use Askvortsov\AutoModerator\Tests\integration\RuleUtils;
use Askvortsov\AutoModerator\Tests\integration\Event\TestEvent;
use Flarum\Group\Group;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;
use Askvortsov\AutoModerator\Tests\integration\Drivers\TestTrigger;
use Illuminate\Contracts\Events\Dispatcher;

class InvalidConditionsTest extends TestCase
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
                $this->normalUser()
            ]
        ]);

        $this->extend((new AutoModerator())
            ->triggerDriver(TestTrigger::class)
            ->metricDriver(MetricReturn15::class)
            ->metricDriver(MetricExplode::class)
            ->requirementDriver(BooleanRequirement::class)
            ->requirementDriver(BooleanRequirementWithSetting::class));
    }

    /**
     * @test
     */
    public function noop()
    {
        $this->setting('automod-rules', json_encode([
            [
                'triggerId' => 'test',
                'actions' => [RuleUtils::genAddToGroupAction(4)]
            ]
        ]));

        $this->app();

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function added_to_group_if_no_requirements_or_metrics()
    {
        $this->setting('automod-rules', json_encode([
            [
                'triggerId' => 'test',
                'actions' => [RuleUtils::genAddToGroupAction(4)]
            ]
        ]));

        $this->app()->getContainer()->make(Dispatcher::class)->dispatch(new TestEvent());

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
    }
}
