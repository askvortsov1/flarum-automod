<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration\criteria;

use Askvortsov\AutoModerator\CriteriaCalculator;
use Askvortsov\AutoModerator\Extend\AutoModerator;
use Askvortsov\AutoModerator\Tests\integration\criteria\Drivers\BooleanRequirement;
use Askvortsov\AutoModerator\Tests\integration\criteria\Drivers\MetricReturn15;
use Askvortsov\AutoModerator\Tests\integration\criteria\Drivers\MetricReturn27;
use Askvortsov\AutoModerator\Tests\integration\CriteriaUtils;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\Activated;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;

class CustomCriteriaGainTest extends TestCase
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
                $this->normalUser()
            ]
        ]);
    }

    /**
     * @test
     */
    public function not_added_to_group_by_default_with_logged_in()
    {
        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_added_to_group_by_default_with_activated()
    {
        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), Activated::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_added_to_group_on_activated_if_drivers_undefined()
    {
        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterionGroupManagement('arbitrary', 4, [
                ['type' => '15', 'min' => 2, 'max' => 100]
            ], [
                ['type' => 'always_true', 'negated' => false, 'settings' => []]
            ]),
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), Activated::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_added_to_group_on_irrelevant_trigger()
    {
        $this->extend(
            (new AutoModerator())
                ->metricDriver('15', MetricReturn15::class)
                ->metricDriver('27', MetricReturn27::class)
                ->requirementDriver('always_true', BooleanRequirement::class),
        );

        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterionGroupManagement('arbitrary', 4, [
                ['type' => '15', 'min' => 2, 'max' => 100]
            ], [
                ['type' => 'always_true', 'negated' => false, 'settings' => []]
            ]),
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), Activated::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function added_to_group_properly_on_activated()
    {
        $this->extend(
            (new AutoModerator())
                ->metricDriver('15', MetricReturn15::class)
                ->metricDriver('27', MetricReturn27::class)
                ->requirementDriver('always_true', BooleanRequirement::class),
        );

        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterionGroupManagement('arbitrary', 4, [
                ['type' => '15', 'min' => 2, 'max' => 100],
                ['type' => '27', 'min' => 2, 'max' => 100]
            ], [
                ['type' => 'always_true', 'negated' => false, 'settings' => []]
            ])
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), Activated::class);

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function added_to_group_properly_on_logged_in()
    {
        $this->extend(
            (new AutoModerator())
                ->metricDriver('15', MetricReturn15::class)
                ->metricDriver('27', MetricReturn27::class)
                ->requirementDriver('always_true', BooleanRequirement::class),
        );
    
        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterionGroupManagement('arbitrary', 4, [
                ['type' => '15', 'min' => 2, 'max' => 100]
            ], [
                ['type' => 'always_true', 'negated' => false, 'settings' => []]
            ]),
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_added_to_group_if_doesnt_apply()
    {
        $this->extend(
            (new AutoModerator())
                ->metricDriver('15', MetricReturn15::class)
                ->metricDriver('27', MetricReturn27::class)
                ->requirementDriver('always_true', BooleanRequirement::class),
        );
    
        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterionGroupManagement('meets metrics but not requirements', 4, [
                ['type' => '15', 'min' => 2, 'max' => 100],
                ['type' => '27', 'min' => 2, 'max' => 100]
            ], [
                ['type' => 'always_true', 'negated' => true, 'settings' => []]
            ]),
            CriteriaUtils::genCriterionGroupManagement('meets requirements but not metrics', 4, [
                ['type' => '15', 'min' => 2, 'max' => 100],
                ['type' => '27', 'min' => 1000, 'max' => -1]
            ], [
                ['type' => 'always_true', 'negated' => false, 'settings' => []]
            ])
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }
}