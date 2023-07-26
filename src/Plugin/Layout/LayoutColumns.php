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

    foreach (['sm', 'md', 'lg', 'xl', 'xxl'] as $prefix) {
      $config[$prefix . '_gap'] = DefaultConfigLayout::GRID_GAP_NONE;
    }

    return $config;
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $parent_form = parent::buildConfigurationForm($form, $form_state);
    $parent_form['gap'] = [
      '#type' => 'select',
      '#title' => $this->t('Gap'),
      '#options' => $this->getGapOptions('none'),
      '#weight' => 5,
      '#default_value' => $this->configuration['gap'],
      '#required' => TRUE,
    ];

    $parent_form['order'] = [
      '#type' => 'select',
      '#title' => $this->t('Column Order'),
      '#options' => [
        'default' => $this->t('Default'),
        'revert' => $this->t('Revert'),
      ],
      '#weight' => 5,
      '#default_value' => $this->configuration['order'] ? $this->configuration['order'] : 'default',
      '#required' => TRUE,
    ];

    foreach (['sm', 'md', 'lg', 'xl', 'xxl'] as $prefix) {
      $parent_form['breakpoints'][$prefix]['gap'] = [
        '#type' => 'select',
        '#title' => $this->t('Gap'),
        '#options' => $this->getGapOptions($prefix),
        '#weight' => 5,
        '#default_value' => $this->configuration[$prefix . '_gap'],
        '#required' => TRUE,
      ];

      $parent_form['breakpoints'][$prefix]['order'] = [
        '#type' => 'select',
        '#title' => $this->t('Column Order'),
        '#options' => [
          'default' => $this->t('Default'),
          $prefix . '-revert' => $this->t('Revert'),
        ],
        '#weight' => 5,
        '#default_value' => $this->configuration[$prefix . '_order'] ? $this->configuration[$prefix . '_order'] : 'default',
        '#required' => TRUE,
      ];
    }

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
    parent::submitConfigurationForm($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['gap'] = $values['gap'];
    $this->configuration['order'] = $values['order'];

    foreach (['sm', 'md', 'lg', 'xl', 'xxl'] as $prefix) {
      $this->configuration[$prefix . '_gap'] = $values['breakpoints'][$prefix]['gap'];
      $this->configuration[$prefix . '_order'] = $values['breakpoints'][$prefix]['order'];
    }
  }

  /**
   * Get the gap options.
   *
   * @return array
   *   The gap options.
   */
  protected function getGapOptions($breakpoint): array {
    switch ($breakpoint) {
      case 'none':
        return [
          DefaultConfigLayout::GRID_GAP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_GAP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_GAP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_GAP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_GAP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_GAP_TRIPLE => $this->t('Triple'),
        ];

      case 'sm':
        return [
          DefaultConfigLayout::GRID_SM_GAP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_SM_GAP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_SM_GAP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_SM_GAP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_SM_GAP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_SM_GAP_TRIPLE => $this->t('Triple'),
        ];

      case 'md':
        return [
          DefaultConfigLayout::GRID_MD_GAP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_MD_GAP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_MD_GAP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_MD_GAP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_MD_GAP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_MD_GAP_TRIPLE => $this->t('Triple'),
        ];

      case 'lg':
        return [
          DefaultConfigLayout::GRID_LG_GAP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_LG_GAP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_LG_GAP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_LG_GAP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_LG_GAP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_LG_GAP_TRIPLE => $this->t('Triple'),
        ];

      case 'xl':
        return [
          DefaultConfigLayout::GRID_XL_GAP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_XL_GAP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_XL_GAP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_XL_GAP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_XL_GAP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_XL_GAP_TRIPLE => $this->t('Triple'),
        ];

      case 'xxl':
        return [
          DefaultConfigLayout::GRID_XXL_GAP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_XXL_GAP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_XXL_GAP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_XXL_GAP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_XXL_GAP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_XXL_GAP_TRIPLE => $this->t('Triple'),
        ];
    }
  }

}
