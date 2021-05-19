<?php

namespace Askvortsov\AutoModerator;

interface DriverManagerInterface
{
    public function getDrivers(bool $inverse = false);
}