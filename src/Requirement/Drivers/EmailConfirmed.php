<?php

namespace Askvortsov\AutoModerator\Requirement\Drivers;

use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\Activated;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

/**
 * @implements RequirementDriverInterface<User>
 */
class EmailConfirmed implements RequirementDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'email_confirmed';
    }

    public function translationKey(): string {
        return 'askvortsov-automod.admin.requirement_drivers.email_confirmed';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function availableSettings(): array
    {
        return [];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [])->errors();
    }

    public function subjectSatisfies(AbstractModel $user, array $settings ): bool {
        return boolval($user->is_email_confirmed);
    }
}
