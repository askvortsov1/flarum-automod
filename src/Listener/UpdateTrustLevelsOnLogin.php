<?php

/*
 * This file is part of askvortsov/flarum-trust-levels
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

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
