<?php

namespace Drupal\publiccode_yml_repositories\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Symfony\Component\Yaml\Yaml;

/**
 * Returns the Name value of the PubliccodeYm content.
 *
 * @see \Drupal\migrate\Plugin\MigrateProcessInterface
 *
 * @MigrateProcessPlugin(
 *   id = "publiccode_yml_name"
 * )
 */
class PubliccodeYmlName extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $publiccode_yml_values = Yaml::parse($value);
    if (isset($publiccode_yml_values) && array_key_exists('name', $publiccode_yml_values) &&  !empty($publiccode_yml_values['name'])) {
      $name = $publiccode_yml_values['name'];
    }
    else {
      $name = $row->getSourceProperty("id");
    }
    return $name;
  }

}
