<?php

namespace Drupal\publiccode_yml_repositories\Plugin\migrate\source;

use Drupal\migrate_plus\Plugin\migrate\source\Url;
use Drupal\migrate\Row;
use Symfony\Component\Yaml\Yaml;

/**
 * Source plugin for retrieving via URLs members data for each Git Project.
 *
 * @MigrateSource(
 *   id = "publiccode_yml_language_url"
 * )
 */
class PubliccodeYmlLanguageUrl extends Url {

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    if ($row->hasSourceProperty('publiccodeYml')) {
      try{
        $publiccode_yml_values = Yaml::parse($row->getSourceProperty('publiccodeYml'));
        // Set a default langcode as italian.
        $langcode = 'it';
        if (isset($publiccode_yml_values) &&
          array_key_exists('description', $publiccode_yml_values) &&
          array_key_exists('en', $publiccode_yml_values['description'])) {
          $langcode = 'en';
        }
        $row->setSourceProperty('langcode', $langcode);
      }
      catch (\Exception $e) {
        watchdog_exception('publiccode_yml_repositories', $e);
      }
    }
    return parent::prepareRow($row);
  }

}
