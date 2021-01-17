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
            'name'   => $trustLevel->name,
            'ranges' => $trustLevel->getRanges(),
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
