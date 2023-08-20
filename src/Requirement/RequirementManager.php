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

use Askvortsov\AutoModerator\DriverManager;
use Askvortsov\AutoModerator\DriverManagerInterface;
use Flarum\Extension\ExtensionManager;

/**
 * @extends DriverManager<RequirementDriverInterface>
 */
class RequirementManager extends DriverManager {}
