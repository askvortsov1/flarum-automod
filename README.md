# Auto Moderator

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/askvortsov1/flarum-automod.svg)](https://packagist.org/packages/askvortsov/flarum-automod)

A [Flarum](http://flarum.org) extension.

## Core Concept

The idea is simple: **When X, if Y, do Z**.

Let's define some key terms:

- **Trigger:** A set of events (usually just one) that can trigger an automation. For example, "Posted", "LoggedIn", "Post liked".
- **Metric:** A numerical quantity. For example, post count or number of likes received.
- **Requirement:** An abstract boolean condition. For example, not being suspended, having an email that matches some regex, etc. 
- **Action:** Some side effect / mutation to perform.  This could include anything from adding/removing a group to sending an email to suspending a user.

Code-wise, these are represented by "Drivers", implementing one of `TriggerDriverInterface`, `MetricDriverInterface`, etc.

_Requirement_ and _Action_ drivers take a list of "settings", which they specify validation rules for. This means you can build a `UserEmailMatchesRegex : RequirementDriverInterface`, or a `AddUserToGroup : ActionDriverInterface`, and then create multiple instances of the drivers with any regex or group ID.

All these are tied together by **Rules**. Rules are stored as [A DATABASE TABLE OR A SETTING, IDK], and specify:

- A trigger for when the rule should run
- A list of metrics "instances". Each instance includes:
  - which metric driver is used
  - a numerical range (could also be a one-sided min or max range). If the value computed by the metric driver falls **in** this range, the metric is satisfied. E.g. "between 10 and 100" likes received
  - a "negation" Boolean. If true, the metric will be satisfied if the value computed by the metric driver falls **outside** of the range
- A list of requirement "instances". Each instance includes:
  - which requirement driver is being used.
  - A value for the requirement driver's config. It will be plugged into the requirement driver to compute whether the requirement is satisfied. E.g. a users email needs to end with "flarum.org"
  - A "negation" Boolean. As with metrics, this allows inverting the requirement driver's output
- a list of actions instances. Each includes:
  - which action driver is used
  - a "settings" value, that will be plugged into an action driver to run the action (e.g. which group to remove a user from)

Trigger drivers specify a list of "subject models", e.g. the author and post in a post created event. These determine which metrics, requirements, and actions are available when defining a rule for some trigger, since "running" a metric, requirement, or action always requires some subject (e.g. which user are we calculating num likes received for, which post are we auto-flagging, etc)

Whenever any event that has rules attached via triggers runs, we "evaluate" all valid rules, and if all the rule's metrics and requirements are satisfied, the rule's actions will run.

A rule is invalid if (1) it has requirements or actions where settings don't pass validation, (2) any of it's components depend on an extension that isn't currently enabled, or (3) any of it's components reference drivers that don't currently exist.

This makes for an **extremely** powerful extension. Since extensions can add their own metrics, requirements, and actions, this extension can automate away a lot of moderation. Beyond the examples listed below, some things that could be possible are:

- Automating assignment of achievements / badges
- Sending emails/notifications to users when they reach thresholds (or just when they register)
- Establishing a system of "trust levels" like [Discourse](https://blog.discourse.org/2018/06/understanding-discourse-trust-levels/)
- Onboard/offboard users to/from external systems when they receive/lose certain group membership
- auto-flagging posts that fail some test

## Testability

Because this system is so generic, we can separate testing the framework for (validating, evaluating, running) rules, from each of the drivers.

Testing drivers is super easy, which makes it cheap and easy to add any drivers we want. See this extension's test suite for examples.

## TODO:

- Implement the frontend for creating, viewing, and editing rules. Maybe there could be a feature to import a `Rule` as JSON, so that rules could be easily shared between forums?
  - We could allow registering form components / config for the settings of certain drivers, so that e.g. "AddUserToGroup" actions could be configured with a real group selector, not just a number field.
  - I've already implemented a metric range selector component.
- Add a ton more drivers.
  - Actions e.g. send emails, flag posts, create warmings 
  - metrics e.g. posts read, time spent, days visited, days since account creation
  - requirements e.g. "user has bio", "post matches regex", etc
- more tests for rule evaluation and validation
- add support for "dated" metrics, e.g. "num discussions created in the past X days"
- cache / store calculated metric values for use by other extensions
- making metric values available to action implementations

### Already Implemented

- interfaces for the various drivers 
  - a bunch of instances of each driver 
  - tests for each instance
- an extender for adding new drivers
- A `Rule` class, including the core validation and evaluation logic for rules
  - And some tests for this, although more would be nice!

## Metrics vs Requirements

Any metric driver could be implemented as a requirement driver, since requirements are more powerful. But if your requirements are about numerical conditions, metric drivers are better because:

- it's easy to specify a range of numbers that is valid
- the output of the metric driver contains the actual value, and so could be used for other features, e.g. calculating a "reputation" score per-user


# EVERYTHING BELOW THIS LINE IS OUTDATED

---

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


## Contributions

Contributions and PRs are welcome! Any PRs adding new drivers should come with unit tests (like with all existing drivers).

## Compatibility

Compatible starting with Flarum 1.0.

## Installation

```sh
composer require askvortsov/flarum-automod:*
```

## Updating

```sh
composer update askvortsov/flarum-automod
```

## Links

- [Packagist](https://packagist.org/packages/askvortsov/flarum-automod)
- [Github](https://github.com/askvortsov1/flarum-automod)
- [Discuss](https://discuss.flarum.org/d/27306-flarum-automoderator)


