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
use Flarum\Extend;
use Flarum\Group\Group;
use Flarum\User\Event\LoggedIn;

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
        ->belongsToMany('trustLevels', TrustLevel::class),

    new Extend\Locales(__DIR__ . '/resources/locale')
];
