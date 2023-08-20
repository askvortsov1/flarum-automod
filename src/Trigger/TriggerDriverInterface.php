<?php

namespace Askvortsov\AutoModerator\Trigger;

use Askvortsov\AutoModerator\DriverInterface;
use Flarum\Database\AbstractModel;

interface TriggerDriverInterface extends DriverInterface
{
    /**
     * Which event is linked to this trigger?
     *
     * @return class-string
     */
    public function eventClass(): string;

    /**
     * Which subjects are part of this trigger?
     *
     * @return list<class-string<AbstractModel>>
     */
    public function subjectClasses(): array;

    /**
     * @template T
     * @param class-string<T> $subjectClass
     * @param mixed $event
     * @return T
     */
    public function getSubject(string $subjectClass, mixed $event): AbstractModel;
}
