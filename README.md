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

This makes for an **extremely** powerful extension. Furthermore, since extensions can add their own metrics, requirements, and actions, this extension can automate away a lot of moderation. Beyond the examples listed below, some things that could be possible are:

- Automating assignment of achievements / badges
- Sending emails/notifications to users when they reach thresholds (or just when they register)
- Establishing a system of "trust levels" like [Discourse](https://blog.discourse.org/2018/06/understanding-discourse-trust-levels/)
- Onboard/offboard users to/from external systems when they receive/lose certain group membership
- And a bunch more! The possibilities are endless.

## Evaluation

When a trigger event occurs:

- All metrics will be calculated for the relevant user (what is the numerical value of the metric?)
- All requirements will be calculated for the relevant user (does the user satisfy each of the requirements?)
- The user's new criteria group will be computed and diffed against the user's current criteria group. The two sets will be diffed. Only criteria triggered by the event will be adjusted.
- Actions will be executed for any gained and lost criteria.

You can also use the `php flarum criteria:recalculate` console command to recalculate criteria for all users. Note that this will be quite slow, and shouldn't usually be done.

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

### Example 3: Auto Activation

**Criteria:** If a user's email matches a regex, activate their email.

The requirement is "a user's email matches a regex". The triggers are saving a user.

The actions are:

- When the criteria is met, auto activate the user's email
- When the criteria are not met, don't 

### Example 4: Default Group

**Criteria:** Add a user to a group

There are no metrics or requirements, so this will be applied to all users on login.

The actions are:

- Add all users to a group on login
## Screenshots

![Admin](https://i.imgur.com/k9zfwd9.png)
![Criterion Edit](https://i.imgur.com/DIgcj48.png)
![Edit User](https://i.imgur.com/8kZZQmT.png)

## Metrics vs Requirements

It's clear to see that any metric could be represented as a Requirement. 

- A requirement must be specific. "More than 50 received likes" could be a requirement. However, metrics can allow for any range of values.
- Metrics can be stored and used for other purposes. For example, a planned feature is combining all metrics to provide a "reputation" score.

## Settings

Requirements and actions can require settings in the admin dashboard. For example:

- The "add to group" action takes the group ID as a setting
- The "suspend" action takes the number of days and whether the suspension is indefinite as settings
- The "email matches regex" requirement takes the regex as a setting

## Extensibility

This extension is extremely flexible. It can be considered a framework for automoderation actions.

Extensions can use the `Askvortsov\AutoModerator\Extend\AutoModerator` extender to add:

- Action drivers
- Metric drivers
- Requirement drivers

You should look at the source code of the default drivers for examples. They're fairly exhaustive of what's offered.

If your extension adds action or requirement drivers that [consume settings](#settings), you have 2 options:

- Provide translation keys for the settings you need in the driver's `availableSettings` method. This is very easy, but also very restrictive. You can only use strings, and can't add any restrictions or UI.
- You can declare a settings form component for your driver. See `js/src/admin/components/SuspendSelector` for an example. The component should take a settings stream as `this.attrs.settings`. The contents of the stream should be an object that maps setting keys to values. The component is responsible for updating the stream on input. You can register a form component by adding its class to `app.autoModeratorForms[DRIVER CATEGORY][TYPE]`, where `DRIVER CATEGORY` is `"action"` or `"requirement"`, and `TYPE` is the type string you registered your driver with in `extend.php`. See `js/src/admin/index.js` for the underlying data structure and examples.

## TODO:

- Add support for more metrics:
  - Posts read
  - Time spent on forum
  - Days visited
  - Days since account creation
  - Etc
- Add support for dated metrics (discussions created in the past X days)
- Introduce metric "weights", sum together to calculate a reputation. Make that reputation available as a metric.
- Develop a data collection extension, which could cache things such as like counts, to improve performance on large forums
- Investigate criterion "listeners": can we generalize stuff like removing links from posts of users without certain groups?

## Contributions

Contributions and PRs are welcome! Any PRs adding new drivers should come with unit tests (like with all existing drivers).

## Compatibility

Compatible starting with Flarum 1.0.

## Installation

```sh
composer require askvortsov/flarum-auto-moderator:*
```

## Updating

```sh
composer update askvortsov/flarum-auto-moderator
```

## Links

- [Packagist](https://packagist.org/packages/askvortsov/flarum-auto-moderator)
- [Github](https://github.com/askvortsov1/flarum-auto-moderator)
- [Discuss](https://discuss.flarum.org/d/27306-flarum-automoderator)
