<?php

namespace Askvortsov\TrustLevels\Listener;

use Askvortsov\TrustLevels\TrustLevelCalculator;
use Flarum\User\Event\LoggedIn;

class UpdateTrustLevelsOnLogin
{
    /**
     * @var TrustLevelCalculator
     */
    protected $calculator;

    public function __construct(TrustLevelCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function handle(LoggedIn $event)
    {
        $this->calculator->recalculate($event->user);
    }
}