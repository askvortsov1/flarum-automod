<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\TrustLevels\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Api\Serializer\GroupSerializer;

class TrustLevelSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'trust_levels';

    /**
     * {@inheritdoc}
     */
    protected function getDefaultAttributes($trustLevel)
    {
        $attributes = [
            'name'                              => $trustLevel->name,
            'minDiscussionsEntered'             => $trustLevel->min_discussions_entered,
            'maxDiscussionsEntered'             => $trustLevel->max_discussions_entered,
            'minDiscussionsParticipated'        => $trustLevel->min_discussions_participated,
            'maxDiscussionsParticipated'        => $trustLevel->max_discussions_participated,
            'minDiscussionsStarted'             => $trustLevel->min_discussions_started,
            'maxDiscussionsStarted'             => $trustLevel->max_discussions_started,
            'minPostsMade'                      => $trustLevel->min_posts_made,
            'maxPostsMade'                      => $trustLevel->max_posts_made,
        ];

        return $attributes;
    }

    /**
     * @return \Tobscure\JsonApi\Relationship
     */
    protected function group($trustLevel)
    {
        return $this->hasOne($trustLevel, GroupSerializer::class);
    }

    /**
     * @return \Tobscure\JsonApi\Relationship
     */
    protected function users($trustLevel)
    {
        return $this->users($trustLevel, BasicUserSerializer::class);
    }
}
