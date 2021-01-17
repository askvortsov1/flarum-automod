<?php

/*
 * This file is part of askvortsov/flarum-trust-levels.
 *
 * Copyright (c) 2021 Alexander Skvortsov.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels;

use Askvortsov\TrustLevels\Api\Controller;
use Askvortsov\TrustLevels\Api\Serializer\TrustLevelSerializer;
use Flarum\Api\Controller\ListUsersController;
use Flarum\Api\Controller\ShowUserController;
use Flarum\Api\Serializer\UserSerializer;
use Flarum\Extend;
use Flarum\Group\Group;
use Flarum\User\Event\LoggedIn;
use Flarum\User\User;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/resources/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/resources/less/admin.less'),

    (new Extend\Routes('api'))
        ->get('/trust_levels', 'tags.index', Controller\ListTrustLevelsController::class)
        ->post('/trust_levels', 'tags.create', Controller\CreateTrustLevelController::class)
        ->patch('/trust_levels/{id}', 'tags.update', Controller\UpdateTrustLevelController::class)
        ->delete('/trust_levels/{id}', 'tags.delete', Controller\DeleteTrustLevelController::class),

    (new Extend\Model(Group::class))
        ->hasMany('trustLevels', TrustLevel::class),

    (new Extend\Model(User::class))
        ->belongsToMany('trustLevels', TrustLevel::class, 'trust_level_user'),

    (new Extend\ApiSerializer(UserSerializer::class))
        ->hasMany('trustLevels', TrustLevelSerializer::class),

    (new Extend\ApiController(ShowUserController::class))
        ->addInclude('trustLevels'),

    (new Extend\ApiController(ListUsersController::class))
        ->addInclude('trustLevels'),

    (new Extend\Event)
        ->listen(LoggedIn::class, Listener\UpdateTrustLevelsOnLogin::class),

    new Extend\Locales(__DIR__ . '/resources/locale')
];
