<?php

declare(strict_types = 1);

namespace Drupal\bt_layouts\Plugin\Layout;

use Drupal\bt_layouts\DefaultConfigLayout;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;

/**
 * Provides a layout base for custom layouts.
 */
class LayoutColumn extends LayoutDefault {

  /**
   * {@inheritdoc}
   */
  public function build(array $regions): array {
    $build = parent::build($regions);
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'container_type' => DefaultConfigLayout::GRID_CONTAINER_TYPE_DEFAULT,
      'background_color' => DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY,
      'padding_top' => DefaultConfigLayout::GRID_PADDING_TOP_NONE,
      'padding_bottom' => DefaultConfigLayout::GRID_PADDING_BOTTOM_NONE,
      'class' => NULL,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $backgroundColorOptions = $this->getBackgroundColorOptions();
    $paddingTopOptions = $this->getPaddingTopOptions();
    $paddingBottomOptions = $this->getPaddingBottomOptions();

    $form = parent::buildConfigurationForm($form, $form_state);

    $form['container_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Container type'),
      '#options' => [
        'full' => $this->t('Full'),
        'box' => $this->t('Box'),
        'wide' => $this->t('Wide'),
      ],
      '#weight' => 10,
      '#default_value' => $this->configuration['container_type'],
    ];

    $form['background_color'] = [
      '#type' => 'select',
      '#title' => $this->t('Background Color'),
      '#options' => $backgroundColorOptions,
      '#weight' => 20,
      '#default_value' => $this->configuration['background_color'],
    ];

    $form['padding_top'] = [
      '#type' => 'select',
      '#title' => $this->t('Padding Top'),
      '#options' => $paddingTopOptions,
      '#default_value' => $this->configuration['padding_top'],
      '#required' => TRUE,
      '#weight' => 40,
    ];

    $form['padding_bottom'] = [
      '#type' => 'select',
      '#title' => $this->t('Padding Bottom'),
      '#options' => $paddingBottomOptions,
      '#default_value' => $this->configuration['padding_bottom'],
      '#required' => TRUE,
      '#weight' => 50,
    ];

    $form['extra'] = [
      '#type' => 'details',
      '#title' => $this->t('Extra'),
      '#open' => $this->hasExtraSettings(),
      '#weight' => 60,
    ];

    $form['extra']['class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Custom Class'),
      '#description' => $this->t('Enter custom css classes for this row. Separate multiple classes by a space and do not include a period.'),
      '#default_value' => $this->configuration['class'],
      '#attributes' => [
        'placeholder' => 'class-one class-two',
      ],
    ];

    return $form;
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
    $this->configuration['background_color'] = $values['background_color'];
    $this->configuration['padding_top'] = $values['padding_top'];
    $this->configuration['padding_bottom'] = $values['padding_bottom'];
    $this->configuration['class'] = $values['extra']['class'];
  }

  /**
   * Get the top padding options.
   *
   * @return array
   *   The top padding options.
   */
  protected function getPaddingTopOptions(): array {
    return [
      DefaultConfigLayout::GRID_PADDING_TOP_NONE => $this->t('None'),
      DefaultConfigLayout::GRID_PADDING_TOP_HALF => $this->t('Half - 0.5rem'),
      DefaultConfigLayout::GRID_PADDING_TOP_NORMAL => $this->t('Normal - 1rem'),
      DefaultConfigLayout::GRID_PADDING_TOP_DOUBLE => $this->t('Double - 2rem'),
      DefaultConfigLayout::GRID_PADDING_TOP_TRIPLE => $this->t('Triple - 3rem'),
    ];
  }

  /**
   * Get the bottom padding options.
   *
   * @return array
   *   The bottom padding options.
   */
  protected function getPaddingBottomOptions(): array {
    return [
      DefaultConfigLayout::GRID_PADDING_BOTTOM_NONE => $this->t('None'),
      DefaultConfigLayout::GRID_PADDING_BOTTOM_HALF => $this->t('Half - 0.5rem'),
      DefaultConfigLayout::GRID_PADDING_BOTTOM_NORMAL => $this->t('Normal - 1rem'),
      DefaultConfigLayout::GRID_PADDING_BOTTOM_DOUBLE => $this->t('Double - 2rem'),
      DefaultConfigLayout::GRID_PADDING_BOTTOM_TRIPLE => $this->t('Triple - 3rem'),
    ];
  }

  /**
   * Get the background color options.
   *
   * @return array
   *   The background color options.
   */
  protected function getBackgroundColorOptions(): array {
    return [
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_NONE => $this->t('None'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY => $this->t('Primary'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_DARK => $this->t('Primary Dark'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_LIGHT => $this->t('Primary Light'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY => $this->t('Secondary'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_DARK => $this->t('Secondary Dark'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_LIGHT => $this->t('Secondary Light'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT => $this->t('Accent'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_DARK => $this->t('Accent Dark'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_LIGHT => $this->t('Accent Light'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_BACKGROUND => $this->t('Background'),
    ];
  }

  /**
   * Determine if this layout has background settings.
   *
   * @return bool
   *   If this layout has background settings.
   */
  protected function hasBackgroundSettings(): bool {
    if (!empty($this->configuration['background_color'])) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Determine if this layout has extra settings.
   *
   * @return bool
   *   If this layout has extra settings.
   */
  protected function hasExtraSettings(): bool {
    return $this->configuration['class'] || $this->configuration['hero'];
  }

}
