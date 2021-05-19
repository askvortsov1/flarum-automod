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

use Askvortsov\AutoModerator\Extend\AutoModerator;
use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Askvortsov\AutoModerator\Tests\integration\metric\UsesMetric;
use Flarum\Http\AccessToken;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\Activated;
use Flarum\User\Event\LoggedIn;
use Flarum\User\Event\LoggedOut;
use Flarum\User\User;

class CustomCriteriaTest extends TestCase
{
    use RetrievesAuthorizedUsers;
    use UsesMetric;

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
        $this->app()->getContainer()->make('events')->dispatch(new LoggedIn(User::find(2), new AccessToken([])));

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_added_to_group_by_default_with_activated()
    {
        $this->app()->getContainer()->make('events')->dispatch(new Activated(User::find(2)));

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function not_added_to_group_on_activated_if_drivers_undefined()
    {
        $this->prepareDatabase(['criteria' => [
            $this->genCriterion('arbitrary', 4, [
                '15' => [2, 100],
            ], [
                'always_true' => ['negated' => false]
            ]),
        ]]);

        $this->app();
        User::where('id', 2)->first()->refreshCommentCount()->save();
        $this->app()->getContainer()->make('events')->dispatch(new Activated(User::where('id', 2)->first()));

        $this->assertNotContains(4, User::where('id', 2)->first()->groups->pluck('id')->all());
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
            $this->genCriterion('arbitrary', 4, [
                '15' => [2, 100],
            ], [
                'always_true' => ['negated' => false]
            ]),
        ]]);

        $this->app();
        User::where('id', 2)->first()->refreshCommentCount()->save();
        $this->app()->getContainer()->make('events')->dispatch(new Activated(User::where('id', 2)->first()));

        $this->assertNotContains(4, User::where('id', 2)->first()->groups->pluck('id')->all());
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
            $this->genCriterion('arbitrary', 4, [
                '15' => [2, 100],
                '27' => [2, 100],
            ], [
                'always_true' => ['negated' => false]
            ]),
        ]]);

        $this->app();
        User::where('id', 2)->first()->refreshCommentCount()->save();
        $this->app()->getContainer()->make('events')->dispatch(new Activated(User::where('id', 2)->first() ));

        $this->assertContains(4, User::where('id', 2)->first()->groups->pluck('id')->all());
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
            $this->genCriterion('arbitrary', 4, [
                '15' => [2, 100],
            ], [
                'always_true' => ['negated' => false]
            ]),
        ]]);

        $this->app();
        User::where('id', 2)->first()->refreshCommentCount()->save();
        $this->app()->getContainer()->make('events')->dispatch(new LoggedIn(User::where('id', 2)->first(), new AccessToken([])));

        $this->assertContains(4, User::where('id', 2)->first()->groups->pluck('id')->all());
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
            $this->genCriterion('meets metrics but not actions', 4, [
                '15' => [2, 100],
                '27' => [2, 100],
            ], [
                'always_true' => ['negated' => true]
            ]),
            $this->genCriterion('meets actions but not all metrics', 4, [
                '15' => [2, 100],
                '27' => [1000, -1],
            ], [
                'always_true' => ['negated' => false]
            ])
        ]]);

        $this->app();
        User::find(2)->refreshCommentCount()->save();
        $this->app()->getContainer()->make('events')->dispatch(new LoggedIn(User::find(2), new AccessToken([])));

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }
}

class MetricReturn15 implements MetricDriverInterface
{

    public function translationKey(): string {
        return '';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function eventTriggers(): array {
        return [LoggedOut::class => function (LoggedOut $event) {
            return $event->user;
        }];
    }

    public function getValue(User $user): int {
        return 15;
    }
}

class MetricReturn27 implements MetricDriverInterface
{

    public function translationKey(): string
    {
        return '';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function eventTriggers(): array
    {
        return [
            LoggedOut::class => function (LoggedOut $event) {
                return $event->user;
            },
            Activated::class => function (Activated $event) {
                return $event->user;
            },
        ];
    }

    public function getValue(User $user): int
    {
        return 27;
    }
}

class BooleanRequirement implements RequirementDriverInterface
{

    public function translationKey(): string
    {
        return '';
    }

    public function extensionDependencies(): array
    {
        return [];
    }

    public function eventTriggers(): array
    {
        return [];
    }

    public function userSatisfies(User $user): bool
    {
        return true;
    }
}