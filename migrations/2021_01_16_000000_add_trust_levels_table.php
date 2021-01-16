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
        $schema->create('trust_levels', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 100);
            $table->integer('group_id')->unsigned();

            $table->integer('min_discussions_entered');
            $table->integer('max_discussions_entered');

            $table->integer('min_discussions_started');
            $table->integer('max_discussions_started');

            $table->integer('min_posts_made');
            $table->integer('max_posts_made');

            $table->integer('min_discussions_participated');
            $table->integer('max_discussions_participated');

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('trust_levels');
    },
];
