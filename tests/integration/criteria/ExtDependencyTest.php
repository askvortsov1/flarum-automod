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
use Askvortsov\AutoModerator\Metric\MetricDriverInterface;
use Askvortsov\AutoModerator\Tests\integration\CriteriaUtils;
use Askvortsov\AutoModerator\Tests\integration\metric\UsesMetric;
use Carbon\Carbon;
use Flarum\Http\AccessToken;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;

class ExtDependencyTest extends TestCase
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
            ],
        ]);
    }

    /**
     * @test
     */
    public function not_added_to_group_if_in_range_but_ext_missing()
    {
        $this->extend(
            (new AutoModerator())
                ->metricDriver('ext-dependent', MetricDependentOnExt::class)
        );
    
        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterionGroupManagement('dependent on missing ext', 4, [
                ['type' => 'ext-dependent', 'min' => 2, 'max' => 100]
            ])
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertNotContains(4, User::find(2)->groups->pluck('id')->all());
    }

    /**
     * @test
     */
    public function added_to_group_if_in_range_and_ext_enabled()
    {
        $this->extension('flarum-likes');

        $this->extend(
            (new AutoModerator())
                ->metricDriver('ext-dependent', MetricDependentOnExt::class)
        );

        $this->prepareDatabase(['criteria' => [
            CriteriaUtils::genCriterionGroupManagement('dependent on ext', 4, [
                ['type' => 'ext-dependent', 'min' => 2, 'max' => 100]
            ])
        ]]);

        $this->app()->getContainer()->make(CriteriaCalculator::class)->recalculate(User::find(2), LoggedIn::class);

        $this->assertContains(4, User::find(2)->groups->pluck('id')->all());
    }
}

class MetricDependentOnExt implements MetricDriverInterface
{

    public function translationKey(): string
    {
        return '';
    }

    public function extensionDependencies(): array
    {
        return ['flarum-likes'];
    }

    public function eventTriggers(): array
    {
        return [];
    }

    public function getValue(User $user): int
    {
        return 15;
    }
}
