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
use Carbon\Carbon;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\Activated;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;

class CompoundActionGainTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('flarum-suspend');
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
    public function added_to_group_and_suspended()
    {
        $this->extend(
            (new AutoModerator())
                ->metricDriver('15', MetricReturn15::class)
                ->metricDriver('27', MetricReturn27::class)
                ->requirementDriver('always_true', BooleanRequirement::class),
        );

        $actions = [
            [
                'type' => 'add_to_group',
                'gain' => true,
                'settings' => [
                    'group_id' => 4
                ]
            ],
            [
                'type' => 'suspend',
                'gain' => true,
                'settings' => [
                    'days' => 5
                ]
            ],
        ];

        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterion('arbitrary', $actions, [
                ['type' => '15', 'min' => 2, 'max' => 100],
                ['type' => '27', 'min' => 2, 'max' => 100]
            ], [
                ['type' => 'always_true', 'negated' => false, 'settings' => []]
            ])
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), Activated::class);

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
        $this->assertGreaterThan(Carbon::now()->addDays(4), User::find(2)->suspended_until);
        $this->assertLessThan(Carbon::now()->addDays(6), User::find(2)->suspended_until);
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
}
