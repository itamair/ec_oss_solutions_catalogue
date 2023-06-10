<?php

namespace Drupal\git_projects_federator\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_plus\Plugin\migrate\source\Url;
use Drupal\migrate\Row;
use Drupal\Core\Database\Database;

/**
 * Source plugin for retrieving via URLs members data for each Git Project.
 *
 * @MigrateSource(
 *   id = "git_projects_urls"
 * )
 */
class GitProjectsUrls extends Url {

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * The GitLab Helper Service.
   *
   * @var \Drupal\git_projects_federator\Services\GitLabHelper
   */
  protected \Drupal\git_projects_federator\Services\GitLabHelper $gitLabHelper;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);
    $this->gitLabHelper = \Drupal::service('git_projects_federator.gitlab_helper');
    $this->sourceUrls = $this->gitLabHelper->getGitLabProjectsPagesUrls();
    $this->httpClient = \Drupal::httpClient();
  }
}
