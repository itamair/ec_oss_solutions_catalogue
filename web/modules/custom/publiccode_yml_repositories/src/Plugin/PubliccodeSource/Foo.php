<?php

namespace Drupal\publiccode_yml_repositories\Plugin\PubliccodeSource;

use Drupal\publiccode_yml_repositories\PubliccodeSourcePluginBase;

/**
 * Plugin implementation of the publiccode_source.
 *
 * @PubliccodeSource(
 *   id = "foo",
 *   label = @Translation("Foo"),
 *   description = @Translation("Foo description."),
 *   type = "foo",
 * )
 */
class Foo extends PubliccodeSourcePluginBase {

  /**
   * {@inheritdoc}
   */
  public function getPubliccodeYmls() {
    // TODO: Implement getPubliccodeYmls() method.
  }

}
