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
        $schema->create('criterion_user', function (Blueprint $table) {
            $table->integer('criterion_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->primary(['criterion_id', 'user_id']);

            $table->foreign('criterion_id')->references('id')->on('criteria')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('criterion_user');
    },
];
