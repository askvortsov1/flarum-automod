<?php

namespace Askvortsov\AutoModerator\Requirement\Drivers;

use Askvortsov\AutoModerator\Requirement\RequirementDriverInterface;
use Flarum\Database\AbstractModel;
use Flarum\User\Event\Saving;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

/**
 * @implements RequirementDriverInterface<User>
 */
class EmailMatchesRegex implements RequirementDriverInterface
{
    public function subject(): string {
        return User::class;
    }

    public function id(): string {
        return 'email_matches_regex';
    }

    public function translationKey(): string {
        return 'askvortsov-automod.admin.requirement_drivers.email_matches_regex';
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function availableSettings(): array
    {
        return [
            'regex' => 'askvortsov-automod.admin.in_group_settings.regex'
        ];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [
            'regex' => 'required|string',
        ])->errors();
    }

    public function subjectSatisfies(AbstractModel $user, array $settings ): bool {
        $regex = $settings['regex'];
        return boolval(preg_match("/$regex/", $user->email));
    }
}
