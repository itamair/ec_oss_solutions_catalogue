<?php

namespace Drupal\git_projects_federator\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use Drupal\Component\Serialization\Json;

/**
 * Provides a GitHub Helper Service.
 */
class GitHubHelper {

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
   * The GitHub Projects Endpoint.
   *
   * @var string
   */
  protected string $projectsEndPoint;

  /**
   * The GitHub Users Endpoint.
   *
   * @var string
   */
  protected string $usersEndPoint;

  /**
   * The GitHub Projects Pages Urls list.
   *
   * @var array
   */
  public array $gitHubProjectsPagesUrls;

  /**
   * The GitHub Users Pages Urls list.
   *
   * @var array
   */
  public array $gitHubUsersPagesUrls;

  /**
   * The GitHub Access Token.
   *
   * @var string
   */
  private string $gitAccessToken = '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';

  /**
   * Constructor of the GitHub Helper Service.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client.
   */
  public function __construct(
    ClientInterface $http_client
  ) {
    $this->perPage = 30;
    $this->httpClient = $http_client;
  }

  /**
   * Get GitHub Access Token.
   *
   * @return string
   *   The GitHub Access Token.
   */
  public function getGitAccessToken(): string {
    return $this->gitAccessToken;
  }

  /**
   * Get GitHub Project Info.
   *
   *  @param string $github_owner
   *   The GitHub owner string.
   *
   * @param string $project_name
   *   The GitHub project name string.
   *
   * @return array
   *   The GitHub Projects Pages Urls list.
   */
  public function githubProjectInfo(string $github_owner, string $project_name): array {
    $options = [
      'headers' => [
        'Authorization' => 'Bearer ' . $this->gitAccessToken,
      ],
    ];
    $project_end_point = 'https://api.github.com/repos/' . $github_owner . '/' . $project_name;
    try {
      $response = $this->httpClient->get($project_end_point, $options);
      return JSON::decode($response->getBody()->getContents());
    }
    catch (ConnectException $e) {
      return [];
    }
  }

  /**
   * Return the GitHub Projects Endpoint.
   *
   *  @param string $github_owner
   *   The GitHub owner string.
   *
   * @return string
   *   The Projects Endpoint path.
   */
  public function getReposEndpoint(string $github_owner): string {
    return 'https://api.github.com/orgs/' . $github_owner . '/repos';
  }

  /**
   * Get the GitHub Projects Pages Urls list.
   *
   *  @param string $github_owner
   *   The GitHub owner string.
   *
   * @return array
   *   The GitHub Projects Pages Urls list.
   */
  public function getGitHubProjectsPagesUrls(string $github_owner): array {
    $next_pattern = '/(?<=<)([\S]*)(?=>; rel="Next")/i';
    $pages_remaining = TRUE;
    $github_projects_pages_urls = [];
    $options = [
      'headers' => [
        'Authorization' => 'Bearer ' . $this->gitAccessToken,
      ],
      'query' => [
        'per_page' => $this->perPage,
      ],
    ];

    $github_projects_pages_urls[] = $this->getReposEndpoint($github_owner);

    // Generate the GitHub projects pages endpoints urls, based on the perPage
    // configuration and the total projects found.
    while ($pages_remaining) {
      try {
        $github_projects_pages_urls_response = $this->httpClient->get($github_projects_pages_urls[count($github_projects_pages_urls) - 1], $options);
        $github_projects_pages_urls_response_headers = $github_projects_pages_urls_response->getHeaders();

        $link_header = $github_projects_pages_urls_response_headers['Link'][0] ?? NULL;
        $pages_remaining = isset($link_header) && str_contains($link_header, 'rel="next"');

        // Tmp set $pages_remaining to FALSE to run only one iteration with
        // $per_page.
        $pages_remaining = FALSE;
        if ($pages_remaining) {
          $github_projects_pages_urls[] = preg_match($next_pattern, $link_header);
        }
      }
      catch (ConnectException $e) {
        \Drupal::messenger()->addError(t('@e. Migrations cannot be performed because of connection failure to: @hostname', [
          '@e' => $e->getMessage(),
          '@hostname' => $this->getReposEndpoint($github_owner),
        ]));
        return [];
      }
    }
    return $github_projects_pages_urls;
  }

}
