<?php

namespace Askvortsov\TrustLevels;

use Flarum\Database\AbstractModel;
use Flarum\Database\ScopeVisibilityTrait;
use Flarum\Group\Group;
use Flarum\User\User;

/**
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @property int $min_discussions_entered
 * @property int $max_discussions_entered
 * @property int $min_discussions_started
 * @property int $max_discussions_started
 * @property int $min_posts_made
 * @property int $max_posts_made
 * @property int $min_discussions_participated
 * @property int $max_discussions_participated
 */
class TrustLevel extends AbstractModel
{
    use ScopeVisibilityTrait;

    protected $table = 'trust_levels';

    /**
     * Create a new trust level.
     *
     * @param string $name
     * @param string $group
     * @return static
     */
    public static function build($name, $group)
    {
        $tag = new static;

        $tag->name = $name;
        $tag->group = $group;

        return $tag;
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

