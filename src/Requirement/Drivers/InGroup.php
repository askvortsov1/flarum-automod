<?php

namespace Askvortsov\AutoModerator\Requirement;

use Flarum\User\Event\Activated;
use Flarum\User\Event\GroupsChanged;
use Flarum\User\User;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Factory;

class InGroup implements RequirementDriverInterface
{

    public function translationKey(): string {
        return 'askvortsov-auto-moderator.admin.requirement_drivers.in_group';
    }

    public function availableSettings(): array
    {
        return [
            'group_id' => 'askvortsov-auto-moderator.lib.group_id'
        ];
    }

    public function validateSettings(array $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings, [
            'group_id' => 'required|integer',
        ])->errors();
    }

    public function extensionDependencies(): array {
        return [];
    }

    public function eventTriggers(): array {
        return [
            GroupsChanged::class => function (GroupsChanged $event) {
                return $event->user;
            }
        ];
    }

    public function userSatisfies(User $user, array $settings = []): bool {
        return $user->groups()->where('groups.id', $settings['group_id'])->exists();
    }
}