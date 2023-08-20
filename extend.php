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
        ->actionDriver('activate_email', Action\Drivers\ActivateEmail::class)
        ->actionDriver('add_to_group', Action\Drivers\AddToGroup::class)
        ->actionDriver('remove_from_group', Action\Drivers\RemoveFromGroup::class)
        ->actionDriver('suspend', Action\Drivers\Suspend::class)
        ->actionDriver('unsuspend', Action\Drivers\Unsuspend::class)
        ->metricDriver('discussions_entered', Metric\Drivers\DiscussionsEntered::class)
        ->metricDriver('discussions_started', Metric\Drivers\DiscussionsStarted::class)
        ->metricDriver('discussions_participated', Metric\Drivers\DiscussionsParticipated::class)
        ->metricDriver('posts_made', Metric\Drivers\PostsMade::class)
        ->metricDriver('likes_given', Metric\Drivers\LikesGiven::class)
        ->metricDriver('likes_received', Metric\Drivers\LikesReceived::class)
        ->metricDriver('best_answers', Metric\Drivers\BestAnswers::class)
        ->metricDriver('moderator_strikes', Metric\Drivers\ModeratorStrikes::class)
        ->requirementDriver('email_confirmed', Requirement\Drivers\EmailConfirmed::class)
        ->requirementDriver('email_matches_regex', Requirement\Drivers\EmailMatchesRegex::class)
        ->requirementDriver('in_group', Requirement\Drivers\InGroup::class)
        ->requirementDriver('suspended', Requirement\Drivers\Suspended::class),
];
