<?php

namespace Drupal\publiccode_yml_repositories\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Symfony\Component\Yaml\Yaml;

/**
 * Returns the Description It value of the PubliccodeYm content.
 *
 * @see \Drupal\migrate\Plugin\MigrateProcessInterface
 *
 * @MigrateProcessPlugin(
 *   id = "publiccode_yml_description_it"
 * )
 */
class PubliccodeYmlDescriptionIt extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $publiccode_yml_values = Yaml::parse($value);
    $description_it = '';
    if (isset($publiccode_yml_values) &&
      array_key_exists('description', $publiccode_yml_values) &&
      array_key_exists('it', $publiccode_yml_values['description']) &&
      array_key_exists('longDescription', $publiccode_yml_values['description']['it']) &&
      !empty($publiccode_yml_values['description']['it']['longDescription'])) {
      $description_it = $publiccode_yml_values['description']['it']['longDescription'];
    }
    return $description_it;
  }

}
