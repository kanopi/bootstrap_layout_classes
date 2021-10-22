# Boostrap Layout Classes Widget

Provides functionality for editing and rendering Bootstrap layout classes.

## Installation

### Composer
If your site is [managed via Composer](https://www.drupal.org/node/2718229), use Composer to download the module:

   ```sh
   composer require "drupal/boostrap_layout_classes"
   ```

## Configuration

### Field
On the desired content or paragraph type create a plain text field (cardinality of limited 1), e.g. `field_layout`.

### Widget
Set the form display to "Boostrap Layout Classes" and use the options to choose which layout classes to allow.

### Formatter
Set the display to a hidden label and "Boostrap Layout Classes" formatter.
