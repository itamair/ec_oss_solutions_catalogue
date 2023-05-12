<?php

namespace Drupal\publiccode_yml_repositories;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for publiccode_source plugins.
 */
abstract class PubliccodeSourcePluginBase extends PluginBase implements PubliccodeSourceInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

  /**
   * {@inheritdoc}
   */
  public function type() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['type'];
  }

}
