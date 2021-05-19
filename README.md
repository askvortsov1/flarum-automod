# Auto Moderator

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/askvortsov1/flarum-auto-moderator.svg)](https://packagist.org/packages/askvortsov/flarum-auto-moderator)

A [Flarum](http://flarum.org) extension.

## Core Concept

The core idea is as follows:

When a user meets criteria X, do Y. When a user no longer meets criteria X, do Z. 

Let's define some key terms:

- **Criteria Group:** The set of all criteria that a user meets.
- **Criteria (singular Criterion):** An arbitrary set of conditions. Criteria are paired with triggers and actions, and are composed of:
  - **Metrics:** A numerical condition. For example, post count or number of likes received. A criterion could require a range/minimum/maximum of metrics.
  - **Requirement:** An abstract boolean condition. For example, not being suspended, or having an email that matches a certain regex.
- **Action:** Something that happens automatically when a criteria is met or lost. This could include anything from adding/removing a group to sending an email to suspending a user.
- **Triggers:** A set of events that would cause a user's criteria groups to be reevaluated. These are associated with metrics and Requirements. `LoggedIn` is automatically a trigger for all criteria.

## Evaluation

When a trigger event occurs:

- All metrics will be calculated for the relevant user (what is the numerical value of the metric?)
- All requirements will be calculated for the relevant user (does the user satisfy each of the requirements?)
- The user's new criteria group will be computed and diffed against the user's current criteria group. The two sets will be diffed. Only criteria triggered by the event will be adjusted.
- Actions will be executed for any gained and lost criteria.

## Examples

### Example 1: Group Management

**Criteria:** Users that receive 50 or more likes and have started at least 10 discussions should placed in the "Active" group.

Here, the metrics are "received 50 or more likes" and "have started at least 10 discussions". Unsurprisingly, they come with the triggers (`PostWasLiked`, `PostWasUnliked`) and (`Discussion\Started`) respectively.

The actions are:

- When the criteria is met, add the user to the "Active" group
- When the criteria is lost, remove the user from the "Active" group

### Example 2: Suspension

**Criteria:** If a user gets 15 warnings or more and is not an admin, suspend them.

Here, the metrics are "gets 15 warnings or more" and the requirements are "is not an admin". The triggers would be a new warning for the metric. The requirement has no triggers.

The actions are:

- When the criteria is met, suspend them
- When the criteria is lost, unsuspend them

## Metrics vs Requirements

It's clear to see that any metric could be represented as a Requirement. However, metrics are highly preferable if possible:

- A requirement must be specific. "More than 50 received likes" could be a requirement. However, metrics can allow for any range of values.
- Metrics can be stored and used for other purposes. For example, a planned feature is combining all metrics to provide a "reputation" score.

## Action Settings

When you add requirements to a criterion, you indicate whether that requirement must be met, must not be met, or whether it shouldn't apply.

When you add metrics to a criterion, you indicate a range of values.

Actions can define their own settings. So when you add an action to a criterion, you might be prompted to fill in some settings. This allows creating generic actions, such as adding a user to an arbitrary group.

## Extensibility


This extension is extremely flexible. It can be considered a framework for automoderation actions.

Extensions can use the `Askvortsov\AutoModerator\Extend\AutoModerator` extender to add:

- Action drivers
- Metric drivers
- Requirement drivers

If your extension is adding actions that have settings, you might also want to introduce a custom action setting component.
See [this extension's group settings components](https://github.com/askvortsov1/flarum-auto-moderator/blob/b0f194acd7f360f01ec0b2588ddf9efe019894d1/js/src/admin/index.js#L13-L18) for an example. Essentially, you'll need to add an entry to `app["askvortsov-auto-moderator"].actionDriverSettingsComponents` where the key is the action's type string (provided via the extender), and the value is a component class. The component class should take an action item (an object with a `settings` property; the settings item is a map of setting keys to values), and is responsible for updating the `settings` property in that action item.

### TODO:

- Add support for more metrics:
  - Posts read
  - Time spent on forum
  - Days visited
  - Days since account creation
  - Etc
- Add support for dated metrics (discussions created in the past X days)
- Introduce metric "weights", sum together to calculate a reputation. Make that reputation available as a metric.
- Develop a data collection extension, which could cache things such as like counts, to improve performance on large forums

### Screenshots

![Admin](https://i.imgur.com/k9zfwd9.png)
![Criterion Edit](https://i.imgur.com/AkEYxRs.png)
![Edit User](https://i.imgur.com/T8sqsor.png)


### Installation

```sh
composer require askvortsov/flarum-auto-moderator:*
```

### Updating

```sh
composer update askvortsov/flarum-auto-moderator
```

### Links

- [Packagist](https://packagist.org/packages/askvortsov/flarum-auto-moderator)
- [Github](https://github.com/askvortsov1/flarum-auto-moderator)
- [Discuss](https://discuss.flarum.org/d/25977-trust-levels-automatic-group-assignment)
