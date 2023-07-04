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
    $config = [
      'background_color' => DefaultConfigLayout::GRID_BACKGROUND_COLOR_DEFAULT,
      'class' => NULL,
      'container_select' => DefaultConfigLayout::GRID_CONTAINER_SELECT,
      'full_select' => DefaultConfigLayout::GRID_FULL_SELECT,
      'box_select' => DefaultConfigLayout::GRID_BOX_SELECT,
      'padding_top' => DefaultConfigLayout::GRID_PADDING_TOP_NONE,
      'padding_bottom' => DefaultConfigLayout::GRID_PADDING_BOTTOM_NONE,
    ];

    foreach (['sm', 'md', 'lg', 'xl', 'xxl'] as $prefix) {
      $config[$prefix . '_container_select'] = DefaultConfigLayout::GRID_CONTAINER_SELECT;
      $config[$prefix . '_full_select'] = DefaultConfigLayout::GRID_FULL_SELECT;
      $config[$prefix . '_box_select'] = DefaultConfigLayout::GRID_BOX_SELECT;
      $config[$prefix . '_padding_top'] = DefaultConfigLayout::GRID_PADDING_TOP_NONE;
      $config[$prefix . '_padding_bottom'] = DefaultConfigLayout::GRID_PADDING_BOTTOM_NONE;
    }
    return $config;
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $backgroundColorOptions = $this->getBackgroundColorOptions();
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['hide_label'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide label'),
      '#default_value' => $this->configuration['hide_label'] ? $this->configuration['hide_label'] : TRUE,
      '#weight' => 1,
    ];

    $form['label_color'] = [
      '#type' => 'select',
      '#title' => $this->t('Label Color'),
      '#options' => $backgroundColorOptions,
      '#weight' => 2,
      '#default_value' => $this->configuration['label_color'],
      '#states' => [
        'visible' => [
          ':input[name="layout_settings[hide_label]"]' => ['checked' => FALSE],
        ],
      ],
    ];

    $form['label_custom_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Custom color'),
      '#description' => $this->t("Select a custom label color."),
      '#default_value' => $this->configuration['label_custom_color'],
      '#weight' => 3,
      '#states' => [
        'visible' => [
          ':input[name="layout_settings[label_color]"]' => ['value' => 'customColor'],
        ],
      ],
    ];

    $form['background_color'] = [
      '#type' => 'select',
      '#title' => $this->t('Background Color'),
      '#options' => $backgroundColorOptions,
      '#weight' => 6,
      '#default_value' => $this->configuration['background_color'] ? $this->configuration['background_color'] : 'default',
    ];

    $form['background_custom_color'] = [
      '#type' => 'color',
      '#title' => $this->t('Custom color'),
      '#description' => $this->t("Select a custom color as background."),
      '#default_value' => $this->configuration['background_custom_color'],
      '#weight' => 7,
      '#states' => [
        'visible' => [
          ':input[name="layout_settings[background_color]"]' => ['value' => 'customColor'],
        ],
      ],
    ];

    $form['container_select'] = [
      '#type' => 'select',
      '#options' => [
        'full' => $this->t('Full'),
        'box' => $this->t('Box'),
      ],
      '#title' => $this->t('Container Type'),
      '#description' => $this->t("Select a container type for the width."),
      '#default_value' => $this->configuration['container_select'],
      '#weight' => 8,
    ];

    $form['full_select'] = [
      '#type' => 'select',
      '#options' => [
        '0' => $this->t('100%'),
        '5%' => $this->t('90%'),
        '10%' => $this->t('80%'),
        '15%' => $this->t('70%'),
        '20%' => $this->t('60%'),
      ],
      '#title' => $this->t('Full Container Width'),
      '#description' => $this->t("Select a width."),
      '#default_value' => $this->configuration['full_select'],
      '#states' => [
        'visible' => [
          ':input[name="layout_settings[container_select]"]' => ['value' => 'full'],
        ],
      ],
      '#weight' => 9,
    ];

    $form['box_select'] = [
      '#type' => 'select',
      '#options' => [
        '100%' => $this->t('100%'),
        '90%' => $this->t('90%'),
        '80%' => $this->t('80%'),
        '70%' => $this->t('70%'),
        '60%' => $this->t('60%'),
      ],
      '#title' => $this->t('Box Container Width'),
      '#description' => $this->t("Select a width."),
      '#default_value' => $this->configuration['box_select'],
      '#states' => [
        'visible' => [
          ':input[name="layout_settings[container_select]"]' => ['value' => 'box'],
        ],
      ],
      '#weight' => 10,
    ];

    $form['height'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Height'),
      '#description' => $this->t('Enter a height. Examples: 100vh, 400px.'),
      '#default_value' => $this->configuration['height'],
      '#weight' => 11,
    ];

    $form['padding_top'] = [
      '#type' => 'select',
      '#title' => $this->t('Padding Top'),
      '#options' => $this->getPaddingTopOptions('none'),
      '#default_value' => $this->configuration['padding_top'] ? $this->configuration['padding_top'] : 'none',
      '#required' => TRUE,
      '#weight' => 11,
    ];

    $form['padding_bottom'] = [
      '#type' => 'select',
      '#title' => $this->t('Padding Bottom'),
      '#options' => $this->getPaddingBottomOptions('none'),
      '#default_value' => $this->configuration['padding_bottom'] ? $this->configuration['padding_bottom'] : 'none',
      '#required' => TRUE,
      '#weight' => 12,
    ];

    $screens = [
      'sm' => $this->t('min-width: 576px'),
      'md' => $this->t('min-width: 768px'),
      'lg' => $this->t('min-width: 992px'),
      'xl' => $this->t('min-width: 1200px'),
      'xxl' => $this->t('min-width: 1400px'),
    ];

    $form['breakpoints'] = [
      '#type' => 'details',
      '#title' => $this->t('Breakpoints'),
      '#tree' => TRUE,
      '#weight' => 20,
    ];

    foreach ($screens as $prefix => $breakpoint) {
      $form['breakpoints'][$prefix] = [
        '#type' => 'details',
        '#title' => $breakpoint,
        '#tree' => TRUE,
      ];

      $form['breakpoints'][$prefix][$prefix . '_container_select'] = [
        '#type' => 'select',
        '#options' => [
          'full' => $this->t('Full'),
          'box' => $this->t('Box'),
        ],
        '#title' => $this->t('Container Type'),
        '#description' => $this->t("Select a container type for the width."),
        '#default_value' => $this->configuration[$prefix . '_container_select'],
        '#weight' => 7,
      ];

      $form['breakpoints'][$prefix][$prefix . '_full_select'] = [
        '#type' => 'select',
        '#options' => [
          '0' => $this->t('100%'),
          '5%' => $this->t('90%'),
          '10%' => $this->t('80%'),
          '15%' => $this->t('70%'),
          '20%' => $this->t('60%'),
        ],
        '#title' => $this->t('Full Container Width'),
        '#description' => $this->t("Select a width."),
        '#default_value' => $this->configuration[$prefix . '_full_select'],
        '#states' => [
          'visible' => [
            ':input[name="layout_settings[breakpoints][' . $prefix . '][' . $prefix . '_container_select]"]' => ['value' => 'full'],
          ],
        ],
        '#weight' => 8,
      ];

      $form['breakpoints'][$prefix][$prefix . '_box_select'] = [
        '#type' => 'select',
        '#options' => [
          '100%' => $this->t('100%'),
          '90%' => $this->t('90%'),
          '80%' => $this->t('80%'),
          '70%' => $this->t('70%'),
          '60%' => $this->t('60%'),
        ],
        '#title' => $this->t('Box Container Width'),
        '#description' => $this->t("Select a width."),
        '#default_value' => $this->configuration[$prefix . '_box_select'],
        '#states' => [
          'visible' => [
            ':input[name="layout_settings[breakpoints][' . $prefix . '][' . $prefix . '_container_select]"]' => ['value' => 'box'],
          ],
        ],
        '#weight' => 9,
      ];

      $form['breakpoints'][$prefix][$prefix . '_height'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Height'),
        '#description' => $this->t('Enter a height. Examples: 100vh, 400px.'),
        '#default_value' => $this->configuration[$prefix . '_height'] ? $this->configuration[$prefix . '_height'] : '',
        '#weight' => 6,
      ];

      $form['breakpoints'][$prefix][$prefix . '_padding_top'] = [
        '#type' => 'select',
        '#title' => $this->t('Padding Top'),
        '#options' => $this->getPaddingTopOptions($prefix),
        '#default_value' => $this->configuration[$prefix . '_padding_top'] ? $this->configuration[$prefix . '_padding_top'] : 'none',
        '#required' => TRUE,
        '#weight' => 10,
      ];

      $form['breakpoints'][$prefix][$prefix . '_padding_bottom'] = [
        '#type' => 'select',
        '#title' => $this->t('Padding Bottom'),
        '#options' => $this->getPaddingBottomOptions($prefix),
        '#default_value' => $this->configuration[$prefix . '_padding_bottom'] ? $this->configuration[$prefix . '_padding_bottom'] : 'none',
        '#required' => TRUE,
        '#weight' => 11,
      ];
    }

    $form['extra'] = [
      '#type' => 'details',
      '#title' => $this->t('Extra'),
      '#open' => $this->hasExtraSettings(),
      '#weight' => 12,
    ];

    $form['extra']['class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Custom Class'),
      '#description' => $this->t('Enter custom css classes for this row. Separate multiple classes by a space and do not include a period.'),
      '#default_value' => $this->configuration['class'],
      '#attributes' => [
        'placeholder' => 'class-one class-two',
      ],
      '#weight' => 13,
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
    $this->configuration['hide_label'] = $values['hide_label'];
    $this->configuration['label_color'] = $values['label_color'];
    $this->configuration['label_custom_color'] = $values['label_custom_color'];
    $this->configuration['background_color'] = $values['background_color'];
    $this->configuration['background_custom_color'] = $values['background_custom_color'];
    $this->configuration['class'] = $values['extra']['class'];
    $this->configuration['container_select'] = $values['container_select'];
    $this->configuration['full_select'] = $values['full_select'];
    $this->configuration['box_select'] = $values['box_select'];
    $this->configuration['height'] = $values['height'];
    $this->configuration['padding_top'] = $values['padding_top'];
    $this->configuration['padding_bottom'] = $values['padding_bottom'];

    foreach (['sm', 'md', 'lg', 'xl', 'xxl'] as $prefix) {
      $this->configuration[$prefix . '_container_select'] = $values['breakpoints'][$prefix][$prefix . '_container_select'];
      $this->configuration[$prefix . '_full_select'] = $values['breakpoints'][$prefix][$prefix . '_full_select'];
      $this->configuration[$prefix . '_box_select'] = $values['breakpoints'][$prefix][$prefix . '_box_select'];
      $this->configuration[$prefix . '_height'] = ['breakpoints'][$prefix][$prefix . '_height'];
      $this->configuration[$prefix . '_padding_top'] = $values['breakpoints'][$prefix][$prefix . '_padding_top'];
      $this->configuration[$prefix . '_padding_bottom'] = $values['breakpoints'][$prefix][$prefix . '_padding_bottom'];
    }
  }

  /**
   * Get the top padding options.
   *
   * @return array
   *   The top padding options.
   */
  protected function getPaddingTopOptions($breakpoint): array {
    switch ($breakpoint) {
      case 'none':
        return [
          DefaultConfigLayout::GRID_PADDING_TOP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_PADDING_TOP_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_PADDING_TOP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_PADDING_TOP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_PADDING_TOP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_PADDING_TOP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_PADDING_TOP_TRIPLE => $this->t('Triple'),
        ];

      case 'sm':
        return [
          DefaultConfigLayout::GRID_SM_PADDING_TOP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_SM_PADDING_TOP_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_SM_PADDING_TOP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_SM_PADDING_TOP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_SM_PADDING_TOP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_SM_PADDING_TOP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_SM_PADDING_TOP_TRIPLE => $this->t('Triple'),
        ];

      case 'md':
        return [
          DefaultConfigLayout::GRID_MD_PADDING_TOP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_MD_PADDING_TOP_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_MD_PADDING_TOP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_MD_PADDING_TOP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_MD_PADDING_TOP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_MD_PADDING_TOP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_MD_PADDING_TOP_TRIPLE => $this->t('Triple'),
        ];

      case 'lg':
        return [
          DefaultConfigLayout::GRID_LG_PADDING_TOP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_LG_PADDING_TOP_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_LG_PADDING_TOP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_LG_PADDING_TOP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_LG_PADDING_TOP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_LG_PADDING_TOP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_LG_PADDING_TOP_TRIPLE => $this->t('Triple'),
        ];

      case 'xl':
        return [
          DefaultConfigLayout::GRID_XL_PADDING_TOP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_XL_PADDING_TOP_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_XL_PADDING_TOP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_XL_PADDING_TOP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_XL_PADDING_TOP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_XL_PADDING_TOP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_XL_PADDING_TOP_TRIPLE => $this->t('Triple'),
        ];

      case 'xxl':
        return [
          DefaultConfigLayout::GRID_XXL_PADDING_TOP_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_XXL_PADDING_TOP_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_XXL_PADDING_TOP_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_XXL_PADDING_TOP_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_XXL_PADDING_TOP_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_XXL_PADDING_TOP_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_XXL_PADDING_TOP_TRIPLE => $this->t('Triple'),
        ];
    }
  }

  /**
   * Get the bottom padding options.
   *
   * @return array
   *   The bottom padding options.
   */
  protected function getPaddingBottomOptions($breakpoint): array {
    switch ($breakpoint) {
      case 'none':
        return [
          DefaultConfigLayout::GRID_PADDING_BOTTOM_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_PADDING_BOTTOM_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_PADDING_BOTTOM_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_PADDING_BOTTOM_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_PADDING_BOTTOM_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_PADDING_BOTTOM_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_PADDING_BOTTOM_TRIPLE => $this->t('Triple'),
        ];

      case 'sm':
        return [
          DefaultConfigLayout::GRID_SM_PADDING_BOTTOM_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_SM_PADDING_BOTTOM_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_SM_PADDING_BOTTOM_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_SM_PADDING_BOTTOM_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_SM_PADDING_BOTTOM_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_SM_PADDING_BOTTOM_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_SM_PADDING_BOTTOM_TRIPLE => $this->t('Triple'),
        ];

      case 'md':
        return [
          DefaultConfigLayout::GRID_MD_PADDING_BOTTOM_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_MD_PADDING_BOTTOM_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_MD_PADDING_BOTTOM_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_MD_PADDING_BOTTOM_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_MD_PADDING_BOTTOM_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_MD_PADDING_BOTTOM_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_MD_PADDING_BOTTOM_TRIPLE => $this->t('Triple'),
        ];

      case 'lg':
        return [
          DefaultConfigLayout::GRID_LG_PADDING_BOTTOM_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_LG_PADDING_BOTTOM_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_LG_PADDING_BOTTOM_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_LG_PADDING_BOTTOM_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_LG_PADDING_BOTTOM_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_LG_PADDING_BOTTOM_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_LG_PADDING_BOTTOM_TRIPLE => $this->t('Triple'),
        ];

      case 'xl':
        return [
          DefaultConfigLayout::GRID_XL_PADDING_BOTTOM_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_XL_PADDING_BOTTOM_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_XL_PADDING_BOTTOM_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_XL_PADDING_BOTTOM_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_XL_PADDING_BOTTOM_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_XL_PADDING_BOTTOM_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_XL_PADDING_BOTTOM_TRIPLE => $this->t('Triple'),
        ];

      case 'xxl':
        return [
          DefaultConfigLayout::GRID_XXL_PADDING_BOTTOM_NONE => $this->t('None'),
          DefaultConfigLayout::GRID_XXL_PADDING_BOTTOM_ZERO => $this->t('Zero'),
          DefaultConfigLayout::GRID_XXL_PADDING_BOTTOM_SMALL => $this->t('Small'),
          DefaultConfigLayout::GRID_XXL_PADDING_BOTTOM_HALF => $this->t('Half'),
          DefaultConfigLayout::GRID_XXL_PADDING_BOTTOM_NORMAL => $this->t('Normal'),
          DefaultConfigLayout::GRID_XXL_PADDING_BOTTOM_DOUBLE => $this->t('Double'),
          DefaultConfigLayout::GRID_XXL_PADDING_BOTTOM_TRIPLE => $this->t('Triple'),
        ];
    }
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
    return $this->configuration['class'] || FALSE;
  }

}
