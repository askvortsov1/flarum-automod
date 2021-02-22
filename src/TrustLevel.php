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
 * @property array $metrics
 */
class TrustLevel extends AbstractModel
{
    use ScopeVisibilityTrait;

    protected $table = 'trust_levels';

    protected $jsonMetrics;

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
        $tag->jsonMetrics = [];

        return $tag;
    }

    /**
     * @inheritDoc
     */
    public function save(array $options = [])
    {
        $this->calcMetrics();

        parent::save($options);
    }

    public function getMetrics()
    {
        if (!$this->jsonMetrics) {
            $this->jsonMetrics = json_decode($this->metrics, true);
        }

        return $this->jsonMetrics;
    }

    public function getMetricMin($metricName)
    {
        $this->getMetrics();

        return Arr::get($this->jsonMetrics, "min$metricName", -1);
    }

    public function getMetricMax($metricName)
    {
        $this->getMetrics();

        return Arr::get($this->jsonMetrics, "max$metricName", -1);
    }

    public function setMetric($metricName, $min, $max)
    {
        $this->getMetrics();

        $this->jsonMetrics["min$metricName"] = (int) $min;
        $this->jsonMetrics["max$metricName"] = (int) $max;
    }

    public function calcMetrics()
    {
        if ($this->jsonMetrics) {
            $this->metrics = json_encode($this->jsonMetrics);
        }

        return $this->metrics;
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

