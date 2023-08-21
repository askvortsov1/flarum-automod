<?php

namespace Askvortsov\AutoModerator\Trigger;

use Askvortsov\AutoModerator\DriverInterface;
use Flarum\Database\AbstractModel;

/**
 * @template E
 */
interface TriggerDriverInterface extends DriverInterface
{
    /**
     * Which event is linked to this trigger?
     *
     * @return class-string<E>
     */
    public function eventClass(): string;

    /**
     * Which subjects are part of this trigger?
     *
     * @return list<class-string<AbstractModel>>
     */
    public function subjectClasses(): array;

    /**
     * @template T of AbstractModel
     * @param class-string<T> $subjectClass
     * @param mixed $event
     * @return T
     */
    public function getSubject(string $subjectClass, mixed $event): AbstractModel;
}
