<?php

namespace Drupal\publiccode_yml_repositories\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

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
    /** @var \Drupal\publiccode_yml_repositories\Services\PubliccodeYmlParserInterface $publiccode_yml_parser */
    $publiccode_yml_parser = \Drupal::service('publiccode_yml_parser');
    $description_block = $publiccode_yml_parser->descriptionBlock($value);
    $description = '';
    $langcode = $row->getSourceProperty('langcode') ?? 'it';
    if (!empty($description_block) &&
      array_key_exists($langcode, $description_block) &&
      array_key_exists('longDescription', $description_block[$langcode]) &&
      !empty($description_block[$langcode]['longDescription'])) {
      $description = $description_block[$langcode]['longDescription'];
    }
    return $description;
  }

}
