<?php

/*
 * This file is part of askvortsov/flarum-moderator-warnings
 *
 *  Copyright (c) 2020 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->create('trust_level_user', function (Blueprint $table) {
            $table->integer('trust_level_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->primary(['trust_level_id', 'user_id']);

            $table->foreign('trust_level_id')->references('id')->on('trust_levels')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('trust_level_user');
    },
];
