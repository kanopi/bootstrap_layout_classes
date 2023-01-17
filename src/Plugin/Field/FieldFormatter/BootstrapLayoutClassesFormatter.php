<?php

namespace Drupal\bootstrap_layout_classes\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'country' formatter showing the iso code.
 *
 * @FieldFormatter(
 *   id = "bootstrap_layout_classes_formatter",
 *   module = "bootstrap_layout_classes",
 *   label = @Translation("Bootstrap Layout Classes"),
 *   description = @Translation("add a value as a class"),
 *   field_types = {
 *     "string",
 *     "text",
 *     "list_string"
 *   }
 * )
 */
class BootstrapLayoutClassesFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $classArray = [];

    foreach ($items as $delta => $item) {
      // Drupal\options\Plugin\Field\FieldType\ListStringItem
      // dpm(get_class($item));
      // dpm($item->getString());
      // dpm($item->getValue());
      $classArray[] = str_replace('_', '-', $item->getString());
    }

    // $element['#css_class_source'] = $classArraySource;
    $element['#css_class'] = $classArray;
    $element['#css_target'] = 'node';
    $element['#css_depth'] = '1';

    // Instead of outputting the value on the page
    // we are inserting it as a class into the markup.
    return $element;
  }

}
