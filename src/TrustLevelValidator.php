<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels;

use Flarum\Foundation\AbstractValidator;

class TrustLevelValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'name' => ['required'],
        'min_discussions_entered' => ['required', 'int', 'lte:max_discussions_entered'],
        'max_discussions_entered' => ['required', 'int', 'gte:min_discussions_entered'],
        'min_discussions_participated' => ['required','int', 'lte:max_discussions_participated'],
        'max_discussions_participated' => ['required','int', 'gte:min_discussions_participated'],
        'min_discussions_started' => ['required','int', 'lte:max_discussions_started'],
        'max_discussions_started' => ['required','int', 'gte:min_discussions_started'],
        'min_posts_made' => ['required','int', 'lte:max_posts_made'],
        'max_posts_made' => ['required','int', 'gte:min_posts_made'],
    ];
}
