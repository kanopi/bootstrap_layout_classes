# Boostrap Layout Classes Widget

Provides functionality for editing and rendering Bootstrap layout classes.

For a full description of the module, visit the
[project page](https://www.drupal.org/project/boostrap_layout_classes).

Submit bug reports and feature suggestions, or track changes in the
[issue queue](https://www.drupal.org/project/issues/boostrap_layout_classes).


## Requirements

This module requires no modules outside of Drupal core.


## Installation

Install as you would normally install a contributed Drupal module. For further
information, see
[Installing Drupal Modules](https://www.drupal.org/docs/extending-drupal/installing-drupal-modules).


## Composer

If your site is [managed via Composer](https://www.drupal.org/node/2718229), use Composer to download the module:

```sh
composer require "drupal/boostrap_layout_classes"
```


## Configuration

The module has no menu or modifiable settings. There is no configuration. When
enabled, the module will prevent the links from appearing. To get the links
back, disable the module and clear caches.


## Field

On the desired content or paragraph type create a plain text field (cardinality of limited 1), e.g. `field_layout`.


## Widget

Set the form display to "Boostrap Layout Classes" and use the options to choose which layout classes to allow.


## Formatter

Set the display to a hidden label and "Boostrap Layout Classes" formatter.