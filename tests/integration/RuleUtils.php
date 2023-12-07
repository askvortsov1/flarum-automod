<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Tests\integration;

class RuleUtils
{
    public static function genAddToGroupAction($groupId)
    {
        return
            [
                'id' => 'add_to_group',
                'settings' => [
                    'group_id' => $groupId
                ]
            ];
    }
}
