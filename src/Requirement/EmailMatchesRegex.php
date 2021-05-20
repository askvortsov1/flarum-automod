<?php

namespace Askvortsov\AutoModerator\Requirement;

use Flarum\User\Event\Saving;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

class EmailMatchesRegex implements RequirementDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-auto-moderator.admin.requirement_drivers.email_matches_regex';
    }

    public function availableSettings(): array
    {
        return [
            'regex' => 'askvortsov-auto-moderator.admin.in_group_settings.regex'
        ];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [
            'regex' => 'required|string',
        ])->errors();
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function eventTriggers(): array {
        return [
            Saving::class => function (Saving $event) {
                return $event->user;
            }
        ];
    }

    public function userSatisfies(User $user, array $settings = []): bool {
        $regex = $settings['regex'];
        return boolval(preg_match("/$regex/", $user->email));
    }
}