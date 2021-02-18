<?php

namespace Askvortsov\TrustLevels;

use Flarum\Database\AbstractModel;
use Flarum\Database\ScopeVisibilityTrait;
use Flarum\Group\Group;
use Flarum\User\User;
use Illuminate\Support\Arr;

/**
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @property array $ranges
 */
class TrustLevel extends AbstractModel
{
    use ScopeVisibilityTrait;

    protected $table = 'trust_levels';

    protected $jsonRanges;

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
        $tag->group()->associate($group);
        $tag->jsonRanges = [];

        return $tag;
    }

    /**
     * @inheritDoc
     */
    public function save(array $options = [])
    {
        parent::save($options);
    }

    public function getRanges()
    {
        if (!$this->jsonRanges) {
            $this->jsonRanges = json_decode($this->ranges, true);
        }

        return $this->jsonRanges;
    }

    public function getRangeMin($rangeName)
    {
        $this->getRanges();

        return Arr::get($this->jsonRanges, "min$rangeName", -1);
    }

    public function getRangeMax($rangeName)
    {
        $this->getRanges();

        return Arr::get($this->jsonRanges, "max$rangeName", -1);
    }

    public function setRange($rangeName, $min, $max)
    {
        $this->getRanges();

        $this->jsonRanges["min$rangeName"] = (int) $min;
        $this->jsonRanges["max$rangeName"] = (int) $max;
    }

    public function calcRanges()
    {
        if ($this->jsonRanges) {
            $this->ranges = json_encode($this->jsonRanges);
        }

        return $this->ranges;
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'trust_level_user');
    }
}

