<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator;

use Askvortsov\AutoModerator\Api\Controller;
use Askvortsov\AutoModerator\Api\Serializer\CriterionSerializer;
use Askvortsov\AutoModerator\Console\RecalculateCriteria;
use Askvortsov\AutoModerator\Extend\AutoModerator;
use Askvortsov\AutoModerator\Provider\AutoModeratorProvider;
use Flarum\Api\Controller\ListUsersController;
use Flarum\Api\Controller\ShowUserController;
use Flarum\Api\Serializer\UserSerializer;
use Flarum\Extend;
use Flarum\User\Event\Registered;
use Flarum\User\User;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less'),

    (new Extend\Routes('api'))
        ->get('/criteria', 'criteria.index', Controller\ListCriteriaController::class)
        ->post('/criteria', 'criteria.create', Controller\CreateCriterionController::class)
        ->get('/criteria/{id}', 'criteria.show', Controller\ShowCriterionController::class)
        ->patch('/criteria/{id}', 'criteria.update', Controller\UpdateCriterionController::class)
        ->delete('/criteria/{id}', 'criteria.delete', Controller\DeleteCriterionController::class)
        ->get('/automod_drivers', 'automod_drivers.index', Controller\ShowAutomoderatorDriversController::class),

    (new Extend\Model(User::class))
        ->belongsToMany('criteria', Criterion::class, 'criterion_user'),

    (new Extend\ApiSerializer(UserSerializer::class))
        ->hasMany('criteria', CriterionSerializer::class),

    (new Extend\ApiController(ShowUserController::class))
        ->addInclude('criteria'),

    (new Extend\ApiController(ListUsersController::class))
        ->addInclude('criteria'),

    (new Extend\ServiceProvider)
        ->register(AutoModeratorProvider::class),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\Console())
        ->command(RecalculateCriteria::class),

    (new AutoModerator())
        ->actionDriver('activate_email', Action\ActivateEmail::class)
        ->actionDriver('add_to_group', Action\AddToGroup::class)
        ->actionDriver('remove_from_group', Action\RemoveFromGroup::class)
        ->actionDriver('suspend', Action\Suspend::class)
        ->actionDriver('unsuspend', Action\Unsuspend::class)
        ->metricDriver('discussions_entered', Metric\DiscussionsEntered::class)
        ->metricDriver('discussions_started', Metric\DiscussionsStarted::class)
        ->metricDriver('discussions_participated', Metric\DiscussionsParticipated::class)
        ->metricDriver('posts_made', Metric\PostsMade::class)
        ->metricDriver('likes_given', Metric\LikesGiven::class)
        ->metricDriver('likes_received', Metric\LikesReceived::class)
        ->metricDriver('best_answers', Metric\BestAnswers::class)
        ->metricDriver('moderator_strikes', Metric\ModeratorStrikes::class)
        ->requirementDriver('email_confirmed', Requirement\EmailConfirmed::class)
        ->requirementDriver('email_matches_regex', Requirement\EmailMatchesRegex::class)
        ->requirementDriver('in_group', Requirement\InGroup::class)
        ->requirementDriver('suspended', Requirement\Suspended::class),
];
