<?php

/**
 * @file
 * Definition of Drupal\boostrap_layout_classes\Plugin\Field\FieldFormatter\BoostrapLayoutClassesWidget.
 *
 * @see https://www.drupal.org/docs/8/creating-custom-modules/create-a-custom-field-formatter
 */

namespace Drupal\boostrap_layout_classes\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'boostrap_layout_classes_widget' widget.
 *
 * @FieldWidget(
 *   id = "boostrap_layout_classes_widget",
 *   module = "boostrap_layout_classes",
 *   label = @Translation("Bootstrap Layout Classes"),
 *   field_types = {
 *     "string",
 *     "text"
 *   }
 * )
 */
class BoostrapLayoutClassesWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'usage' => 2,
      'wrapper' => 0,
      'container' => FALSE,
      'col' => TRUE,
      'offset' => FALSE,
      'order' => FALSE,
      'margin' => TRUE,
      'padding' => TRUE,
      'gutter' => TRUE,
      'align-items' => FALSE,
      'align-self' => FALSE,
      'justify-content' => FALSE,
      'custom' => FALSE,
    ] + parent::defaultSettings();
  }

  static $settings_options_usage = [
      0 => 'Container',
      1 => 'Row',
      2 => 'Column',
    ];
  static $settings_options_wrapper = [
      0 => 'Fieldset',
      1 => 'Details',
    ];
  static $settings_options = [
      'container' => 'Container',
      'col' => 'Columns',
      'offset' => 'Offset',
      'order' => 'Order',
      'margin' => 'Margin',
      'padding' => 'Padding',
      'gutter' => 'Gutters',
      'align-items' => 'Align Items',
      'align-self' => 'Align Self',
      'justify-content' => 'Justify Content',
      'custom' => 'Custom Classes',
    ];

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['usage'] = [
      '#type' => 'select',
      '#title' => $this->t('Classes for'),
      '#options' => self::$settings_options_usage,
      '#default_value' => $this->getSetting('usage'),
    ];
    $element['wrapper'] = [
      '#type' => 'select',
      '#title' => $this->t('Display as'),
      '#options' => self::$settings_options_wrapper,
      '#default_value' => $this->getSetting('wrapper'),
    ];

    foreach (self::$settings_options as $option => $title) {
      $element[$option] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Select ' . $title),
        '#default_value' => $this->getSetting($option),
      ];
    }

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $enabled = [];
    foreach (self::$settings_options as $option => $title) {
      if ($this->getSetting($option)) $enabled[] = $title;
    }

    $summary = [];
    $summary[] = $this->t('Options for') . ' ' . self::$settings_options_usage[$this->getSetting('usage')];
    $summary[] = $this->t('Display as') . ' ' . self::$settings_options_wrapper[$this->getSetting('wrapper')];
    $summary[] = $this->t('Classes') . ': ' . implode(' + ', $enabled);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $values = self::split($value);

    $options_container = [
      '' => '-',
      'container' => 'Container',
      // 'container-sm' => 'Small',
      // 'container-md' => 'Medium',
      // 'container-lg' => 'Large',
      // 'container-xl' => 'X-Large',
      // 'container-xxl' => 'X-Large',
      'container-fluid' => 'Fluid',
    ];
    //      '#empty_option' => '--',

    $options_width = [
      '' => '←',
      '1' => '8%',
      '2' => '17%',
      '3' => '25%',
      '4' => '33%',
      '5' => '42%',
      '6' => '50%',
      '7' => '58%',
      '8' => '67%',
      '9' => '75%',
      '10' => '83%',
      '11' => '92%',
      '12' => '100%',
    ];

    $options_offset = [
      '' => 'Auto',
      '1' => '8%',
      '2' => '17%',
      '3' => '25%',
      '4' => '33%',
      '5' => '42%',
      '6' => '50%',
      '7' => '58%',
      '8' => '67%',
      '9' => '75%',
      '10' => '83%',
      '11' => '92%',
      '12' => '100%',
    ];
    $options_order = [
      '' => 'Auto',
      'first' => 'Erstes',
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      '6' => '6',
      '7' => '7',
      '8' => '8',
      '9' => '9',
      '10' => '10',
      '11' => '11',
      '12' => '12',
      'last' => $this->t('Last'),
    ];

    $options_spacing = [
      '' => '-',
      '0' => '0',
      '1' => '1',
      '2' => '2',
      '3' => '3',
      '4' => '4',
      '5' => '5',
      'auto' => $this->t('Auto'),
    ];

    $options_align = [
      '' => $this->t('Auto'),
      'start' => $this->t('Start'),
      'center' => $this->t('Center'),
      'end' => $this->t('End'),
    ];

    $breakpoints = [
      '' => $this->t('Standard'),
      '-sm' => '≥ 576px',
      '-md' => '≥ 768px',
      '-lg' => '≥ 992px',
      '-xl' => '≥ 1200px',
    ];
    $selects = [];
    if ($this->getSetting('col')
        || self::hasAny($values, ['col','col-sm','col-md','col-lg','col-xl'])) {
      $selects['col'] = [$this->t('Columns'), $options_width];
    }
    if ($this->getSetting('offset')
        || self::hasAny($values, ['offset','offset-sm','offset-md','offset-lg','offset-xl'])) {
      $selects['offset'] = [$this->t('Offset'), $options_offset];
    }
    if ($this->getSetting('order')
        || self::hasAny($values, ['order','order-sm','order-md','order-lg','order-xl'])) {
      $selects['order'] = [$this->t('Order'), $options_order];
    }

    if (!empty($selects)) {
      $element['layout'] = [
        '#type' => 'table',
        //'#caption' => t('Layout Options'),
        '#header' => [
          $this->t('Option'),
          $this->t('Standard'),
          '≥ 576px',
          '≥ 768px',
          '≥ 992px',
          '≥ 1200px',
        ],
      ];
    }
    foreach ($selects as $select => list($select_name, $select_options)) {
      $element['layout'][$select]['name'] = [
        '#plain_text' => $select_name,
      ];
      foreach ($breakpoints as $breakpoint => $breakpoint_name) {
        $element['layout'][$select][$select . $breakpoint] = [
          '#type' => 'select',
          '#title' => $select_name . ' ' . $breakpoint_name,
          '#title_display' => 'invisible',
          '#options' => $select_options,
          '#default_value' => $values[$select . $breakpoint],
        ];
      }
    }

    if ($this->getSetting('margin') || self::hasAny($values, ['mt','ml','mr','mb'])) {
      $element['margin'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Outer'),
        '#attributes' => ['class' => ['container-inline', 'dpad']],
      ];
      $element['margin']['mt'] = [
        '#type' => 'select',
        '#title' => $this->t('Top'), // "↓)"
        '#options' => $options_spacing,
        '#default_value' => $values['mt'],
      ];
      $element['margin']['ml'] = [
        '#type' => 'select',
        '#title' => $this->t('Left'), // "→)"
        '#options' => $options_spacing,
        '#default_value' => $values['ml'],
      ];
      $element['margin']['mr'] = [
        '#type' => 'select',
        '#title' => $this->t('Right'), // "←)"
        '#options' => $options_spacing,
        '#default_value' => $values['mr'],
      ];
      $element['margin']['mb'] = [
        '#type' => 'select',
        '#title' => $this->t('Bottom'), // "↑)"
        '#options' => $options_spacing,
        '#default_value' => $values['mb'],
      ];
    }

    if ($this->getSetting('padding') || self::hasAny($values, ['pt','pl','pr','pb'])) {
      $element['padding'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Inner'),
        '#attributes' => ['class' => ['container-inline', 'dpad']],
      ];
      $element['padding']['pt'] = [
        '#type' => 'select',
        '#title' => $this->t('Top'),
        '#options' => $options_spacing,
        '#default_value' => $values['pt'],
      ];
      $element['padding']['pl'] = [
        '#type' => 'select',
        '#title' => $this->t('Left'),
        '#options' => $options_spacing,
        '#default_value' => $values['pl'],
      ];
      $element['padding']['pr'] = [
        '#type' => 'select',
        '#title' => $this->t('Right'),
        '#options' => $options_spacing,
        '#default_value' => $values['pr'],
      ];
      $element['padding']['pb'] = [
        '#type' => 'select',
        '#title' => $this->t('Bottom'),
        '#options' => $options_spacing,
        '#default_value' => $values['pb'],
      ];
    }

    if ($this->getSetting('container')
        || $this->getSetting('align-items')
        || $this->getSetting('align-self')
        || $this->getSetting('justify-content')
        || $this->getSetting('gutter')
        || $this->getSetting('custom')
        || self::hasAny($values, ['container','align-items','align-self','justify-content','gx','custom'])) {
      $element['general'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('General'),
        '#attributes' => ['class' => ['container-inline']],
      ];
      if ($this->getSetting('container') || self::hasAny($values, ['container'])) {
        $element['general']['container'] = [
          '#type' => 'select',
          '#title' => 'Container',
          '#options' => $options_container,
          '#default_value' => $values['container'],
        ];
      }
      if ($this->getSetting('align-items') || self::hasAny($values, ['align-items'])) {
        $element['general']['align-items'] = [
          '#type' => 'select',
          '#title' => $this->getSetting('usage') == 1 ? $this->t('Vertical') : $this->t('Horizontal'),
          '#options' => $options_align,
          '#default_value' => $values['align-items'],
        ];
      }
      if ($this->getSetting('align-self') || self::hasAny($values, ['align-self'])) {
        $element['general']['align-self'] = [
          '#type' => 'select',
          '#title' => $this->t('Vertical'),
          '#options' => $options_align,
          '#default_value' => $values['align-self'],
        ];
      }
      if ($this->getSetting('justify-content') || self::hasAny($values, ['justify-content'])) {
        $element['general']['justify-content'] = [
          '#type' => 'select',
          '#title' => $this->getSetting('usage') == 1 ? $this->t('Horizontal') : $this->t('Vertical'),
          '#options' => $options_align,
          '#default_value' => $values['justify-content'],
        ];
      }
      if ($this->getSetting('gutter') || self::hasAny($values, ['gutter'])) {
        $element['general']['gx'] = [
          '#type' => 'select',
          '#title' => $this->t('Gutter'),
          '#options' => $options_spacing,
          '#default_value' => $values['gx'],
        ];
      }
      if ($this->getSetting('custom') || self::hasAny($values, ['custom'])) {
        $element['general']['custom'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Custom Classes'),
          '#size' => 15,
          '#default_value' => $values['custom'] ?? '',
        ];
      }
    }

    $element += [
      '#type' => $this->getSetting('wrapper') ? 'details' : 'fieldset',
      '#attributes' => ['class' => ['boostrap_layout_classes_widget']],
      '#attached' => ['library' => ['boostrap_layout_classes/form_style']],
    ];
    //return ['value' => $element];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      // get nested items
      $items = array_merge(self::defaultItems(),
        $value['layout']['col'] ?? [],
        $value['layout']['offset'] ?? [],
        $value['layout']['order'] ?? [],
        $value['margin'] ?? [],
        $value['padding'] ?? [],
        $value['general'] ?? []);

      // special handling of *x and *y
      if ($items['mt'] == $items['mb']) {
        $items['my'] = $items['mt'];
        $items['mt'] = '';
        $items['mb'] = '';
      }
      if ($items['ml'] == $items['mr']) {
        $items['mx'] = $items['ml'];
        $items['ml'] = '';
        $items['mr'] = '';
      }
      if ($items['pt'] == $items['pb']) {
        $items['py'] = $items['pt'];
        $items['pt'] = '';
        $items['pb'] = '';
      }
      if ($items['pl'] == $items['pr']) {
        $items['px'] = $items['pl'];
        $items['pl'] = '';
        $items['pr'] = '';
      }
      // compress duplicate col, offset, order
      $prefixes = ['col', 'offset', 'order'];
      $suffixes = ['', '-sm', '-md', '-lg', '-xl'];
      foreach ($prefixes as $prefix) {
        $prev = '';
        foreach ($suffixes as $suffix) {
          if ($items[$prefix . $suffix] == $prev) {
            $items[$prefix . $suffix] = '';
          } elseif (!empty($items[$prefix . $suffix])) {
            $prev = $items[$prefix . $suffix];
          }
        }
      }
      // collect
      $text = [];
      foreach ($items as $key => $item) {
        // special handling of container and custom classes
        if ($key == 'container' || $key == 'custom') {
          if ($item != '') {
            $text[] = $item;
          }
        } else if ($item != '') {
          $text[] = $key . '-' . $item;
        }
      }
      $value['value'] = implode(' ', $text);
    }

    return $values;
  }

  /**
   * Validate the color text field.
   */
  public static function validate($element, FormStateInterface $form_state) {
    $value = $element['#value'];
    if (strlen($value) == 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
    if (!preg_match('/^#([a-f0-9]{6})$/iD', strtolower($value))) {
      $form_state->setError($element, $this->t('Color must be a 6-digit hexadecimal value, suitable for CSS.'));
    }
  }

  /**
   * Check if array has non-empty value for at least one given key.
   */
  static function hasAny($array, $keys) {
    foreach ($keys as $key) {
      if (isset($array[$key]) && $array[$key] != '') {
        return true;
      }
    }
    return false;
  }

  /**
   * Default key/value pairs.
   */
  static function defaultItems() {
    return [
      'container' => '',
      'col' => '',
      'col-sm' => '',
      'col-md' => '',
      'col-lg' => '',
      'col-xl' => '',
      'offset' => '',
      'offset-sm' => '',
      'offset-md' => '',
      'offset-lg' => '',
      'offset-xl' => '',
      'order' => '',
      'order-sm' => '',
      'order-md' => '',
      'order-lg' => '',
      'order-xl' => '',
      'align-items' => '',
      'align-self' => '',
      'justify-content' => '',
      'mt' => '',
      'mb' => '',
      'ml' => '',
      'mr' => '',
      'pt' => '',
      'pb' => '',
      'pl' => '',
      'pr' => '',
      'gx' => '',
    ];
  }

  /**
   * Split text into layout key/values.
   */
  static function split($value) {
    // defaults
    $items = self::defaultItems();
    $custom = [];
    if (isset($value) && !empty($value)) {
      $classes = explode(' ', $value);
      foreach ($classes as $class) {
        $key = $class;
        $val = '';
        // split class into key-val if possible
        $lastdash = strrpos($class, '-');
        if ($lastdash) {
          $key = substr($class, 0, $lastdash);
          $val = substr($class, $lastdash + 1);
        }
        // special handling of *x and *y
        if ($key == 'mx') {
          $items['ml'] = $val;
          $items['mr'] = $val;
        } elseif ($key == 'my') {
          $items['mt'] = $val;
          $items['mb'] = $val;
        } elseif ($key == 'px') {
          $items['pl'] = $val;
          $items['pr'] = $val;
        } elseif ($key == 'py') {
          $items['pt'] = $val;
          $items['pb'] = $val;
        } elseif ($key == 'container') {
          $items['container'] = $class; // store the class
        } elseif (isset($items[$key])) {
          $items[$key] = $val; // store only the value
        } else {
          $custom[] = $class; // custom classes with dash
        }
      }
    }
    if (!empty($custom)) {
      $items['custom'] = implode(' ', $custom);
    }

    return $items;
  }

}