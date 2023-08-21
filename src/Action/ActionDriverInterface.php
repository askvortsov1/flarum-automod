<?php

namespace Askvortsov\AutoModerator\Action;

use Askvortsov\AutoModerator\DriverInterface;
use Askvortsov\AutoModerator\DriverWithSettingsInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\User;

/**
 * @template T of AbstractModel
 */
interface ActionDriverInterface extends DriverInterface, DriverWithSettingsInterface
{
    /**
     * Which subject model does this action affect?
     *
     * @return class-string<T>
     */
    public function subject(): string;

    /**
     * Apply the action to the user.
     * Don't forget to dispatch any events that should be emitted!
     *
     * @param T $subject
     */
    public function execute(AbstractModel $subject, array $settings, User $lastEditedBy);
}
