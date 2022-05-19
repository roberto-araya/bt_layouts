<?php

declare(strict_types = 1);

namespace Drupal\bt_layouts\Plugin\Layout;

use Drupal\bt_layouts\DefaultConfigLayout;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a layout base for custom layouts.
 */
class LayoutTwoColumns extends LayoutColumns {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    $config = parent::defaultConfiguration();
    return $config;
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $columnsOptions = $this->getColumnsOptions();
    $parent_form = parent::buildConfigurationForm($form, $form_state);
    $parent_form['columns_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Columns Size'),
      '#options' => $columnsOptions,
      '#weight' => 15,
      '#default_value' => $this->configuration['columns_size'],
      '#required' => TRUE,
    ];
    return $parent_form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->configuration['label'] = $values['label'];
    $this->configuration['container_type'] = $values['container_type'];
    $this->configuration['columns_size'] = $values['columns_size'];
    $this->configuration['background_color'] = $values['background_color'];
    $this->configuration['background_custom_color'] = $values['background_custom_color'];
    $this->configuration['gap'] = $values['gap'];
    $this->configuration['padding_top'] = $values['padding_top'];
    $this->configuration['padding_bottom'] = $values['padding_bottom'];
    $this->configuration['class'] = $values['extra']['class'];
  }

  /**
   * Columns options.
   *
   * @return array
   *   The column list options.
   */
  protected function getColumnsOptions(): array {
    return [
      '50-50' => $this->t('50-50'),
      '40-60' => $this->t('40-60'),
      '30-70' => $this->t('30-70'),
      '25-75' => $this->t('25-75'),
      '20-80' => $this->t('20-80'),
      '80-20' => $this->t('80-20'),
      '75-25' => $this->t('75-25'),
      '70-30' => $this->t('70-30'),
      '60-40' => $this->t('60-40'),
    ];
  }

}
