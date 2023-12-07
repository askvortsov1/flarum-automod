<?php

namespace Askvortsov\AutoModerator\Tests\integration\Drivers;

use Askvortsov\AutoModerator\Tests\integration\Event\TestEvent;
use Askvortsov\AutoModerator\Trigger\TriggerDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\User;

class TestTrigger implements TriggerDriverInterface
{

    public function eventClass(): string
    {
        return TestEvent::class;
    }

    public function subjectClasses(): array
    {
        return [User::class];
    }

    public function getSubject(string $subjectClass, mixed $event): AbstractModel
    {
        return User::find(2);
    }

    public function id(): string
    {
        return 'test';
    }

    public function translationKey(): string
    {
        return '';
    }

    public function extensionDependencies(): array
    {
        return [];
    }
}
