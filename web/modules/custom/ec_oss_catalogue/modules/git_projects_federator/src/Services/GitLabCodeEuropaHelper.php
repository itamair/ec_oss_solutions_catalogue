<?php

namespace Drupal\git_projects_federator\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Component\Serialization\Json;

/**
 * Provides a GitLab Code Europa Helper Service.
 */
class GitLabCodeEuropaHelper {

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected \GuzzleHttp\ClientInterface $httpClient;

  /**
   * The Number of the Element to retrieve for each page.
   *
   * @var int
   */
  protected int $perPage;

  /**
   * The GitLab Projects Endpoint.
   *
   * @var string
   */
  protected string $projectsEndPoint;

  /**
   * The GitLab Users Endpoint.
   *
   * @var string
   */
  protected string $usersEndPoint;

  /**
   * The GitLab Projects Pages Urls list.
   *
   * @var array
   */
  public array $gitLabProjectsPagesUrls;

  /**
   * The GitLab Users Pages Urls list.
   *
   * @var array
   */
  public array $gitLabUsersPagesUrls;

  /**
   * Constructor of the UnDeveloperGitLabFetcher Service.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   */
  public function __construct(
    ClientInterface $http_client
  ) {
    $this->perPage = 100;
    $this->projectsEndPoint = 'https://code.europa.eu/api/v4/projects';
    $this->usersEndPoint = 'https://code.europa.eu//api/v4/users';
    $this->httpClient = $http_client;
    // $this->gitLabProjectsPagesUrls = $this->setGitLabProjectsPagesUrls();
    // $this->gitLabUsersPagesUrls = $this->setGitLabUsersPagesUrls();
  }

  /**
   * Get GitLab Project Info.
   *
   * @param int $id
   *   The project id.
   *
   * @return array
   *   The GitLab Projects Pages Urls list.
   */
  public function gitLabProjectInfo($id): array {
    $project_end_point = 'https://code.europa.eu/api/v4/projects/' . $id;
    try {
      $response = $this->httpClient->get($project_end_point);
      return JSON::decode($response->getBody()->getContents());
    }
    catch (ConnectException $e) {
      return [];
    }
  }

  /**
   * Set the GitLab Projects Pages Urls list.
   *
   * @return array
   *   The GitLab Projects Pages Urls list.
   */
  protected function setGitLabProjectsPagesUrls(): array {
    $page = 1;
    $total_pages = 1;
    $gitlab_projects_pages_urls = [];
    $options = [
      'query' => [
        'per_page' => $this->perPage,
      ],
    ];

    // Generate the gitlab projects pages endpoints urls, based on the perPage
    // configuration and the total projects found.
    while ($page <= $total_pages) {
      $options['query']['page'] = $page;
      try {
        $gitlab_projects_pages_urls_response = $this->httpClient->get($this->projectsEndPoint, $options);
        $gitlab_projects_pages_urls_response_headers = $gitlab_projects_pages_urls_response->getHeaders();
        // Re-fetch each cycle the number of total pages, to eventually catch
        // meantime updates.
        $total_pages = $gitlab_projects_pages_urls_response_headers['X-Total-Pages'][0];
        $options['query']['page'] = $page;
        $gitlab_projects_pages_urls[] = $this->projectsEndPoint . '?' . UrlHelper::buildQuery($options['query']);
        $page++;

      }
      catch (ConnectException $e) {
        \Drupal::messenger()->addError(t('@e. Migrations cannot be performed because of connection failure to: @hostname', [
          '@e' => $e->getMessage(),
          '@hostname' => $this->projectsEndPoint,
        ]));
        return [];
      }
    }
    return $gitlab_projects_pages_urls;
  }

  /**
   * Return the GitLab Projects Pages Urls list.
   *
   * @return array
   *   The GitLab Projects Pages Urls list.
   */
  public function getGitLabProjectsPagesUrls(): array {
    return $this->gitLabProjectsPagesUrls;
  }

  /**
   * Set the GitLab Users Pages Urls list.
   *
   * @return array
   *   The GitLab Users Pages Urls list.
   */
  protected function setGitLabUsersPagesUrls(): array {
    $page = 1;
    $total_pages = 1;
    $gitlab_users_pages_urls = [];
    $options = [
      'query' => [
        'per_page' => $this->perPage,
      ],
    ];

    // Generate the gitlab projects pages endpoints urls, based on the perPage
    // configuration and the total projects found.
    while ($page <= $total_pages) {
      $options['query']['page'] = $page;
      try {
        $gitlab_users_pages_urls_response = $this->httpClient->get($this->usersEndPoint, $options);
        $gitlab_users_pages_urls_response_headers = $gitlab_users_pages_urls_response->getHeaders();
        // Re-fetch each cycle the number of total pages, to eventually catch
        // meantime updates.
        $total_pages = $gitlab_users_pages_urls_response_headers['X-Total-Pages'][0];
        $options['query']['page'] = $page;
        $gitlab_users_pages_urls[] = $this->usersEndPoint . '?' . UrlHelper::buildQuery($options['query']);
        $page++;

      }
      catch (ConnectException $e) {
        \Drupal::messenger()->addError(t('@e. Migrations cannot be performed because of connection failure to: @hostname', [
          '@e' => $e->getMessage(),
          '@hostname' => $this->projectsEndPoint,
        ]));
        return [];
      }
    }
    return $gitlab_users_pages_urls;
  }

  /**
   * Return the GitLab Users Pages Urls list.
   *
   * @return array
   *   The GitLab Users Pages Urls list.
   */
  public function getGitLabUsersPagesUrls(): array {
    return $this->gitLabUsersPagesUrls;
  }

  /**
   * Return the GitLab Projects Endpoint.
   *
   * @return string
   *   The Projects Endpoint path.
   */
  public function getProjectsEndpoint(): string {
    return $this->projectsEndPoint;
  }

  /**
   * Return the GitLab Users Endpoint.
   *
   * @return string
   *   The Users Endpoint path.
   */
  public function getUsersEndpoint(): string {
    return $this->usersEndPoint;
  }

}
