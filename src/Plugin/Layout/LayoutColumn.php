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

    $form['background_custom_color'] = [
      '#type' => 'color',
      '#title' => t('Custom color'),
      '#description' => t("Select a custom color as background."),
      '#default_value' => $this->configuration['background_custom_color'],
      '#weight' => 30,
      '#states' => [
        'visible' => [
          ':input[name="layout_settings[background_color]"]' => ['value' => 'customColor'],
        ],
      ],
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
    $this->configuration['background_custom_color'] = $values['background_custom_color'];
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
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_DEFAULT => $this->t('Default'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY => $this->t('Primary'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_050 => $this->t('Primary 050'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_100 => $this->t('Primary 100'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_200 => $this->t('Primary 200'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_300 => $this->t('Primary 300'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_400 => $this->t('Primary 400'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_500 => $this->t('Primary 500'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_600 => $this->t('Primary 600'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_700 => $this->t('Primary 700'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_800 => $this->t('Primary 800'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PRIMARY_900 => $this->t('Primary 900'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY => $this->t('Secondary'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_050 => $this->t('Secondary 050'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_100 => $this->t('Secondary 100'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_200 => $this->t('Secondary 200'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_300 => $this->t('Secondary 300'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_400 => $this->t('Secondary 400'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_500 => $this->t('Secondary 500'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_600 => $this->t('Secondary 600'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_700 => $this->t('Secondary 700'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_800 => $this->t('Secondary 800'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SECONDARY_900 => $this->t('Secondary 900'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT => $this->t('Accent'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_050 => $this->t('Accent 050'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_100 => $this->t('Accent 100'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_200 => $this->t('Accent 200'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_300 => $this->t('Accent 300'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_400 => $this->t('Accent 400'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_500 => $this->t('Accent 500'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_600 => $this->t('Accent 600'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_700 => $this->t('Accent 700'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_800 => $this->t('Accent 800'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ACCENT_900 => $this->t('Accent 900'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_SUCCESS => $this->t('Success'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_INFO => $this->t('Info'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_WARNING => $this->t('Warning'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_DANGER => $this->t('Danger'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_LIGHT => $this->t('Light'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_DARK => $this->t('Dark'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_BLUE => $this->t('Blue'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_INDIGO => $this->t('Indigo'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PURPLE => $this->t('Purple'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_PINK => $this->t('Pink'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_RED => $this->t('Red'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_ORANGE => $this->t('Orange'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_YELLOW => $this->t('Yellow'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GREEN => $this->t('Green'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_TEAL => $this->t('Teal'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_CYAN => $this->t('Cyan'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_WHITE => $this->t('White'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_DARK => $this->t('Gray Dark'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_100 => $this->t('Gray 100'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_200 => $this->t('Gray 200'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_300 => $this->t('Gray 300'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_400 => $this->t('Gray 400'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_500 => $this->t('Gray 500'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_600 => $this->t('Gray 600'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_700 => $this->t('Gray 700'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_800 => $this->t('Gray 800'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_GRAY_900 => $this->t('Gray 900'),
      DefaultConfigLayout::GRID_BACKGROUND_COLOR_CUSTOM => $this->t('Custom'),
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
