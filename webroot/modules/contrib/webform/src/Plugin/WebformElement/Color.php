<?php

namespace Drupal\webform\Plugin\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\WebformElementBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Provides a 'color' element.
 *
 * @WebformElement(
 *   id = "color",
 *   api = "https://api.drupal.org/api/drupal/core!lib!Drupal!Core!Render!Element!Color.php/class/Color",
 *   label = @Translation("Color"),
 *   category = @Translation("Advanced elements"),
 * )
 */
class Color extends WebformElementBase {

  /**
   * {@inheritdoc}
   */
  public function getDefaultProperties() {
    return [
      // Color settings.
      'color_size' => 'medium',
    ] + parent::getDefaultProperties();
  }

  /**
   * {@inheritdoc}
   */
  public function prepare(array &$element, WebformSubmissionInterface $webform_submission) {
    parent::prepare($element, $webform_submission);

    // Set the color swatches size.
    $color_size = (isset($element['#color_size'])) ? $element['#color_size'] : 'medium';
    $element['#attributes']['class'][] = 'form-color-' . $color_size;

    // Add helpful attributes to better support older browsers.
    // @see http://www.wufoo.com/html5/types/6-color.html
    $element['#attributes'] += [
      'title' => $this->t('Hexadecimal color'),
      'pattern' => '#[a-f0-9]{6}',
      'placeholder' => '#000000',
    ];

    $element['#attached']['library'][] = 'webform/webform.element.color';
  }

  /**
   * {@inheritdoc}
   */
  public function formatHtml(array &$element, $value, array $options = []) {
    if (empty($value)) {
      return '';
    }

    $format = $this->getFormat($element);
    switch ($format) {
      case 'swatch':
        return [
          '#theme' => 'webform_element_color_value_swatch',
          '#element' => $element,
          '#value' => $value,
          '#options' => $options,
        ];

      default:
        return parent::formatHtml($element, $value, $options);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultFormat() {
    return 'swatch';
  }

  /**
   * {@inheritdoc}
   */
  public function getFormats() {
    return parent::getFormats() + [
      'swatch' => $this->t('Color swatch'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $form['color'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Color settings'),
    ];
    $form['color']['color_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Color swatch size'),
      '#options' => [
        'small' => $this->t('Small (@size)', ['@size' => '16px']),
        'medium' => $this->t('Medium (@size)', ['@size' => '24px']),
        'large' => $this->t('Large (@size)', ['@size' => '32px']),
      ],
      '#required' => TRUE,
    ];
    return $form;
  }

}
