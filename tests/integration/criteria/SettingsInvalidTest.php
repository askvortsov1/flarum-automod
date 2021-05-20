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
use Askvortsov\AutoModerator\Tests\integration\criteria\Drivers\BooleanRequirementWithSetting;
use Askvortsov\AutoModerator\Tests\integration\CriteriaUtils;
use Flarum\Group\Group;
use Flarum\Http\AccessToken;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;

class SettingsInvalidTest extends TestCase
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
    public function not_added_to_group_if_action_settings_invalid()
    {
        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterionGroupManagement('invalid group ID', 'hello there!')
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_added_to_group_if_requirement_settings_invalid()
    {
        $this->extend(
            (new AutoModerator())
                ->requirementDriver('always_true_with_settings', BooleanRequirementWithSetting::class),
        );

        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterionGroupManagement(4, 'hello there!', [], [
                ['type' => 'always_true_with_settings', 'negate' => false, 'settings' => []]
            ])
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_removed_from_group_if_action_settings_invalid()
    {
        $this->extend(
            (new AutoModerator())
                ->requirementDriver('always_true', BooleanRequirement::class)
        );
        
        $this->prepareDatabase([
            'criteria' => [
                CriteriaUtils::genCriterionGroupManagement('invalid group ID', 'hello there!', [], [['type' => 'always_true', 'negated' => true, 'settings' => []]], 1)
            ],
            'criterion_user' => [
                ['criterion_id' => 1, 'user_id' => 1]
            ],
            'group_user' => [
                ['group_id' => Group::MODERATOR_ID, 'user_id' => 2]
            ]
        ]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_removed_from_group_if_requirement_settings_invalid()
    {
        $this->extend(
            (new AutoModerator())
                ->requirementDriver('always_true_with_settings', BooleanRequirementWithSetting::class)
        );

        $this->prepareDatabase([
            'criteria' => [
                CriteriaUtils::genCriterionGroupManagement(4, 'hello there!', [], [
                    ['type' => 'always_true', 'negated' => true, 'settings' => []],
                    ['type' => 'always_true_with_settings', 'negate' => false, 'settings' => []]
                ], 1)
            ],
            'criterion_user' => [
                ['criterion_id' => 1, 'user_id' => 1]
            ],
            'group_user' => [
                ['group_id' => Group::MODERATOR_ID, 'user_id' => 2]
            ]
        ]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
    }
}
