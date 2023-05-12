<?php

namespace Drupal\publiccode_yml_repositories;

/**
 * Interface for publiccode_source plugins.
 */
interface PubliccodeSourceInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

  /**
   * Returns the PubliccodeSource plugin type.
   *
   * @return string
   *   The PubliccodeSource plugin typee.
   */
  public function type();

  /**
   * Returns the list of publiccode.yml urls of this Publiccode Source plugin.
   *
   * @return array
   *   The list of publiccode.yml urls of this Publiccode Source plugin.
   */
  public function getPubliccodeYmls();

}
