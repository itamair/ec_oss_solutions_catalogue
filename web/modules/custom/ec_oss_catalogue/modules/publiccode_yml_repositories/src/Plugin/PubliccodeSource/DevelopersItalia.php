<?php

namespace Drupal\publiccode_yml_repositories\Plugin\PubliccodeSource;

use Drupal\publiccode_yml_repositories\PubliccodeSourcePluginBase;

/**
 * Plugin implementation of "Developers Italia" publiccode_source.
 *
 * @PubliccodeSource(
 *   id = "developers_italia",
 *   label = @Translation("Developers Italia"),
 *   description = @Translation("Developers Italia repository of publiccode.yml projects"),
 *   type = "repository_api",
 *   api_endpoint = "https://api.developers.italia.it/v1/software"
 * )
 */
class DevelopersItalia extends PubliccodeSourcePluginBase {

  /**
   * {@inheritdoc}
   */
  public function getPubliccodeYmls() {
    // TODO: Implement getPubliccodeYmls() method.
  }

}
