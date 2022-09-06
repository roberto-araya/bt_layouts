<?php

declare(strict_types = 1);

namespace Drupal\bt_layouts\Plugin\Layout;

use Drupal\bt_layouts\DefaultConfigLayout;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a layout base for custom layouts.
 */
class LayoutColumns extends LayoutColumn {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    $config = parent::defaultConfiguration();
    $config['gap'] = DefaultConfigLayout::GRID_GAP_NONE;
    return $config;
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $gapOptions = $this->getGapOptions();
    $parent_form = parent::buildConfigurationForm($form, $form_state);
    $parent_form['gap'] = [
      '#type' => 'select',
      '#title' => $this->t('Gap'),
      '#options' => $gapOptions,
      '#weight' => 30,
      '#default_value' => $this->configuration['gap'],
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
    $this->configuration['hide_label'] = $values['hide_label'];
    $this->configuration['container_select'] = $values['container_select'];
    $this->configuration['full_select'] = $values['full_select'];
    $this->configuration['box_select'] = $values['box_select'];
    $this->configuration['label_color'] = $values['label_color'];
    $this->configuration['label_custom_color'] = $values['label_custom_color'];
    $this->configuration['background_color'] = $values['background_color'];
    $this->configuration['background_custom_color'] = $values['background_custom_color'];
    $this->configuration['gap'] = $values['gap'];
    $this->configuration['padding_top'] = $values['padding_top'];
    $this->configuration['padding_bottom'] = $values['padding_bottom'];
    $this->configuration['class'] = $values['extra']['class'];
  }

  /**
   * Get the gap options.
   *
   * @return array
   *   The gap options.
   */
  protected function getGapOptions(): array {
    return [
      DefaultConfigLayout::GRID_GAP_NONE => $this->t('None'),
      DefaultConfigLayout::GRID_GAP_HALF => $this->t('Half - 0.5rem'),
      DefaultConfigLayout::GRID_GAP_NORMAL => $this->t('Normal - 1rem'),
      DefaultConfigLayout::GRID_GAP_DOUBLE => $this->t('Double - 2rem'),
      DefaultConfigLayout::GRID_GAP_TRIPLE => $this->t('Triple - 3rem'),
    ];
  }

}
