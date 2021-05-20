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

            $table->integer('last_edited_by_id')->unsigned();

            $table->string('name', 200);
            $table->string('icon', 50);
            $table->text('description');

            $table->text('metrics');
            $table->text('requirements');
            $table->text('actions');

            $table->foreign('last_edited_by_id')->references('id')->on('users')->onDelete('cascade');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('criteria');
    },
];
