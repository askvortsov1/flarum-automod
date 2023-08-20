<?php

/*
 * This file is part of askvortsov/flarum-automod
 *
 *  Copyright (c) 2021 Alexander Skvortsov.
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace Askvortsov\AutoModerator\Requirement;

use Askvortsov\AutoModerator\DriverInterface;
use Askvortsov\AutoModerator\DriverWithSettingsInterface;
use Flarum\Database\AbstractModel;

/**
 * @template T of AbstractModel
 */
interface RequirementDriverInterface extends DriverInterface, DriverWithSettingsInterface
{
    /**
     * Which subject model is this metric for?
     *
     * @return class-string<T>
     */
    public function subject(): string;

    /**
     * Does the given subject satisfy the requirement?
     *
     * @param T $subject
     */
    public function subjectSafisfies(AbstractModel $subject, array $settings = []): bool;
}
