<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Metric;

use Askvortsov\AutoModerator\DriverInterface;
use Flarum\Database\AbstractModel;

/**
 * @template T of AbstractModel
 */
interface MetricDriverInterface extends DriverInterface
{
    /**
     * Which subject model is this metric for?
     *
     * @return class-string<T>
     */
    public function subject(): string;

    /**
     * Get the current value of this metric for a given subject.
     *
     * @param T $subject
     */
    public function getValue(AbstractModel $subject): int;
}
