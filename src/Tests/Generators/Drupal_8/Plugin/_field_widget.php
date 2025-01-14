<?php

/**
 * @file
 * Contains \Drupal\foo\Plugin\Field\FieldWidget\ExampleWidget.
 */

namespace Drupal\foo\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'foo_example' field widget.
 *
 * @FieldWidget(
 *   id = "foo_example",
 *   label = @Translation("Example"),
 *   field_types = {"string"},
 * )
 */
class ExampleWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  public static function defaultSettings() {
    return [
      'size' => 60,
      'placeholder' => '',
      'prefix' => '',
      'suffix' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings = $this->getSettings();

    $element['size'] = [
      '#type' => 'number',
      '#title' => t('Size of textfield'),
      '#default_value' => $settings['size'],
      '#required' => TRUE,
      '#min' => 1,
    ];
    $element['placeholder'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $settings['placeholder'],
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];
    $element['prefix'] = [
      '#type' => 'textfield',
      '#title' => t('Prefix'),
      '#default_value' => $settings['prefix'],
    ];
    $element['suffix'] = [
      '#type' => 'textfield',
      '#title' => t('Suffix'),
      '#default_value' => $settings['suffix'],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   *
   * @DCG: Optional.
   */
  public function settingsSummary() {
    $settings = $this->getSettings();
    $summary[] = t('Textfield size: @size', ['@size' => $settings['size']]);

    if ($settings['placeholder']) {
      $summary[] = t('Placeholder: @placeholder', ['@placeholder' => $settings['placeholder']]);
    }
    if ($settings['prefix']) {
      $summary[] = t('Prefix: @prefix', ['@prefix' => $settings['prefix']]);
    }
    if ($settings['suffix']) {
      $summary[] = t('Suffix: @suffix', ['@suffix' => $settings['suffix']]);
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $settings = $this->getSettings();
    $element['value'] = $element + [
        '#type' => 'textfield',
        '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
        '#size' => $settings['size'],
        '#placeholder' => $settings['placeholder'],
        '#maxlength' => $this->getFieldSetting('max_length'),
        '#field_prefix' => $settings['prefix'],
        '#field_suffix' => $settings['suffix'],
      ];

    return $element;
  }

}
