<?php

namespace Askvortsov\AutoModerator\Requirement\Drivers;

use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

/**
 * @implements RequirementDriverInterface<User>
 */
class Suspended implements RequirementDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'suspended';
    }

    public function translationKey(): string {
        return 'askvortsov-automod.admin.requirement_drivers.suspended';
    }

    public function extensionDependencies(): array {
        return ['flarum-suspend'];
    }

    public function availableSettings(): array
    {
        return [];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [])->errors();
    }

    public function subjectSatisfies(AbstractModel $user, array $settings): bool {
        /** @phpstan-ignore-next-line */
        return $user->suspended_until !== null;
    }
}
