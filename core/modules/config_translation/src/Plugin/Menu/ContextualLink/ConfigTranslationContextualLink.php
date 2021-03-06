<?php

/**
 * @file
 * Contains \Drupal\config_translation\Plugin\Menu\ContextualLink\ConfigTranslationContextualLink.
 */

namespace Drupal\config_translation\Plugin\Menu\ContextualLink;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Menu\ContextualLinkDefault;

/**
 * Defines a contextual link plugin with a dynamic title.
 */
class ConfigTranslationContextualLink extends ContextualLinkDefault {

  /**
   * The mapper plugin discovery service.
   *
   * @var \Drupal\config_translation\ConfigMapperManagerInterface
   */
  protected $mapperManager;

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    $options = array();
    if (!empty($this->pluginDefinition['title_context'])) {
      $options['context'] = $this->pluginDefinition['title_context'];
    }

    // Take custom 'config_translation_plugin_id' plugin definition key to
    // retrieve title. We need to retrieve a runtime title (as opposed to
    // storing the title on the plugin definition for the link) because
    // it contains translated parts that we need in the runtime language.
    $type_name = Unicode::strtolower($this->mapperManager()->createInstance($this->pluginDefinition['config_translation_plugin_id'])->getTypeLabel());
    return $this->t($this->pluginDefinition['title'], array('@type_name' => $type_name), $options);
  }

  /**
   * Gets the mapper manager.
   *
   * @return \Drupal\config_translation\ConfigMapperManagerInterface
   *   The mapper manager.
   */
  protected function mapperManager() {
    if (!$this->mapperManager) {
      $this->mapperManager = \Drupal::service('plugin.manager.config_translation.mapper');
    }
    return $this->mapperManager;
  }

}
