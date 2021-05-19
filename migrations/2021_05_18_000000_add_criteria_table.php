<?php

/*
 * This file is part of askvortsov/flarum-auto-moderator
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->create('criteria', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 200);
            $table->text('description');

            $table->text('metrics');
            $table->text('requirements');
            $table->text('actions');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('criteria');
    },
];
