<?php

namespace Drupal\publiccode_yml_repositories\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines publiccode_source annotation object.
 *
 * @Annotation
 */
class PubliccodeSource extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $title;

  /**
   * The description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

  /**
   * The type of the PubliccodeSource plugin.
   *
   * @var string
   */
  public $type;

}
