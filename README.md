# Trust Levels

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/askvortsov1/flarum-trust-levels.svg)](https://packagist.org/packages/askvortsov/flarum-trust-levels)

A [Flarum](http://flarum.org) extension.

- Trust levels allow you to automatically manage group membership based on users' activity.
- Each trust level defines criteria that must be met (e.g. discussions started, posts made, etc), and a group.
- Users are automatically added to groups for all the trust levels that they qualify for when they log in.
- Other extensions (or local extenders) can add their own "range drivers"

Inspired by Discourse's trust level system.

### Please Note

- Since these groups are managed automatically, we recommend maintaining a separate set of groups for trust levels.
- If you delete a trust level, you should also delete the associated group; otherwise, users in that trust level will remain in that group.
- To prevent errors, you cannot update a trust level's group after it has been created.
- Any ranges left disabled will not be counted. If all ranges are disabled for a given trust level, ALL users will receive that level.
- If a group is managed by multiple trust levels, the user will be added to the group as long as they are in at least one of the trust levels.

### Extensibility

This extension is extremely flexible, and can be extended to add custom range drivers! If your extension or community has some custom metrics that are important for automatically managing groups, you can make a custom range driver by implementing `Askvortsov\TrustLevels\Range\RangeDriverInterface`, and registering that driver via the `Askvortsov\TrustLevels\Extend\TrustLevel` extender.

### TODO:

- Add support for more ranges:
  - Posts read
  - Time spent on forum
  - Days visited
  - Days since account creation
  - Etc
- Add support for dated ranges (discussions created in the past X days)
- Develop a data collection extension, which could cache things such as like counts, to improve performance on large forums

### Screenshots

![Admin](https://i.imgur.com/nISg5ex.png)
![Set Ranges](https://i.imgur.com/80r0Mr7.png)
![Edit User](https://i.imgur.com/T8sqsor.png)


### Installation

```sh
composer require askvortsov/flarum-trust-levels
```

### Updating

```sh
composer update askvortsov/flarum-trust-levels
```

### Links

- [Packagist](https://packagist.org/packages/askvortsov/flarum-trust-levels)
- [Github](https://github.com/askvortsov1/flarum-trust-levels)
- [Discuss](https://discuss.flarum.org/d/25977-trust-levels-automatic-group-assignment)
