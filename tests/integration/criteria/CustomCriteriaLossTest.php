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
use Flarum\Group\Group;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\Activated;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;

class CustomCriteriaLossTest extends TestCase
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
            ],
            'group_user' => [
                ['group_id' => Group::MODERATOR_ID, 'user_id' => 2]
            ]
        ]);
    }

    /**
     * @test
     */
    public function not_removed_from_group_on_activated_if_drivers_undefined()
    {
        $this->prepareDatabase([
            'criteria' => [
                CriteriaUtils::genCriterionGroupManagement('arbitrary', 4, [
                    ['type' => '15', 'min' => 100, 'max' => -1]
                ], [
                    ['type' => 'always_true', 'negated' => false, 'settings' => []]
                ], 1),
            ],
            'criterion_user' => [
                ['criterion_id' => 1, 'user_id' => 2]
            ]
        ]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), Activated::class);

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_removed_from_group_on_irrelevant_trigger()
    {
        $this->extend(
            (new AutoModerator())
                ->metricDriver('15', MetricReturn15::class)
                ->metricDriver('27', MetricReturn27::class)
                ->requirementDriver('always_true', BooleanRequirement::class),
        );

        $this->prepareDatabase([
            'criteria' => [
                CriteriaUtils::genCriterionGroupManagement('arbitrary', 4, [
                    ['type' => '15', 'min' => 100, 'max' => -1]
                ], [
                    ['type' => 'always_true', 'negated' => false, 'settings' => []]
                ], 1),
            ],
            'criterion_user' => [
                ['criterion_id' => 1, 'user_id' => 2]
            ]
        ]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), Activated::class);

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function removed_from_group_properly_on_activated()
    {
        $this->extend(
            (new AutoModerator())
                ->metricDriver('15', MetricReturn15::class)
                ->metricDriver('27', MetricReturn27::class)
                ->requirementDriver('always_true', BooleanRequirement::class),
        );

        $this->prepareDatabase([
            'criteria' => [
                CriteriaUtils::genCriterionGroupManagement('arbitrary', 4, [
                    ['type' => '15', 'min' => 100, 'max' => -1],
                    ['type' => '27', 'min' => 2, 'max' => 100]
                ], [
                    ['type' => 'always_true', 'negated' => false, 'settings' => []]
                ], 1),
            ],
            'criterion_user' => [
                ['criterion_id' => 1, 'user_id' => 2]
            ]
        ]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), Activated::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function removed_from_group_properly_on_logged_in()
    {
        $this->extend(
            (new AutoModerator())
                ->metricDriver('15', MetricReturn15::class)
                ->metricDriver('27', MetricReturn27::class)
                ->requirementDriver('always_true', BooleanRequirement::class),
        );

        $this->prepareDatabase([
            'criteria' => [
                CriteriaUtils::genCriterionGroupManagement('arbitrary', 4, [
                    ['type' => '15', 'min' => 100, 'max' => -1]
                ], [
                    ['type' => 'always_true', 'negated' => false, 'settings' => []]
                ], 1),
            ],
            'criterion_user' => [
                ['criterion_id' => 1, 'user_id' => 2]
            ]
        ]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }
}
