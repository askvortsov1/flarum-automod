<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator;

use Askvortsov\AutoModerator\Api\Controller;
use Askvortsov\AutoModerator\Extend\AutoModerator;
use Askvortsov\AutoModerator\Provider\AutoModeratorProvider;
use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less'),

    (new Extend\Routes('api'))
        ->get('/automod_drivers', 'automod_drivers.index', Controller\ShowAutomoderatorDriversController::class),

    (new Extend\ServiceProvider)
        ->register(AutoModeratorProvider::class),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new AutoModerator())
        ->actionDriver(Action\Drivers\ActivateEmail::class)
        ->actionDriver(Action\Drivers\AddToGroup::class)
        ->actionDriver(Action\Drivers\RemoveFromGroup::class)
        ->actionDriver(Action\Drivers\Suspend::class)
        ->actionDriver(Action\Drivers\Unsuspend::class)
        ->metricDriver(Metric\Drivers\DiscussionsEntered::class)
        ->metricDriver(Metric\Drivers\DiscussionsStarted::class)
        ->metricDriver(Metric\Drivers\DiscussionsParticipated::class)
        ->metricDriver(Metric\Drivers\PostsMade::class)
        ->metricDriver(Metric\Drivers\LikesGiven::class)
        ->metricDriver(Metric\Drivers\LikesReceived::class)
        ->metricDriver(Metric\Drivers\BestAnswers::class)
        ->metricDriver(Metric\Drivers\ModeratorStrikes::class)
        ->requirementDriver(Requirement\Drivers\EmailConfirmed::class)
        ->requirementDriver(Requirement\Drivers\EmailMatchesRegex::class)
        ->requirementDriver(Requirement\Drivers\InGroup::class)
        ->requirementDriver(Requirement\Drivers\Suspended::class),
];
