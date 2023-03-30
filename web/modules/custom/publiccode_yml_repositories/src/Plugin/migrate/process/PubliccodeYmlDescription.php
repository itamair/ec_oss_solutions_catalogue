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
 *   id = "publiccode_yml_description"
 * )
 */
class PubliccodeYmlDescription extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $publiccode_yml_values = Yaml::parse($value);
    $description = '';
    $langcode = $row->getSourceProperty('langcode') ?? 'it';
    if (isset($publiccode_yml_values) &&
      array_key_exists('description', $publiccode_yml_values) &&
      array_key_exists($langcode, $publiccode_yml_values['description']) &&
      array_key_exists('longDescription', $publiccode_yml_values['description'][$langcode]) &&
      !empty($publiccode_yml_values['description'][$langcode]['longDescription'])) {
      $description = $publiccode_yml_values['description'][$langcode]['longDescription'];
    }
    return $description;
  }

}
