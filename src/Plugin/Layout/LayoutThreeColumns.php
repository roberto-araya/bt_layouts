<?php

declare(strict_types = 1);

namespace Drupal\bt_layouts\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a layout base for custom layouts.
 */
class LayoutThreeColumns extends LayoutTwoColumns {

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
    $parent_form = parent::buildConfigurationForm($form, $form_state);
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
      '33-33-33' => $this->t('33-33-33'),
      '30-30-40' => $this->t('30-30-40'),
      '30-40-30' => $this->t('30-40-30'),
      '30-50-20' => $this->t('30-50-20'),
      '40-30-30' => $this->t('40-30-30'),
      '40-40-20' => $this->t('40-40-20'),
      '40-20-40' => $this->t('40-20-40'),
      '20-40-40' => $this->t('20-40-40'),
      '20-30-50' => $this->t('20-30-50'),
      '20-20-60' => $this->t('20-20-60'),
      '20-50-30' => $this->t('20-50-30'),
      '20-60-20' => $this->t('20-60-20'),
      '50-30-20' => $this->t('50-30-20'),
      '50-20-30' => $this->t('50-20-30'),
      '60-20-20' => $this->t('60-20-20'),
      '25-50-25' => $this->t('25-50-25'),
    ];
  }

}
