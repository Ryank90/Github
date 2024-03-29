<?php

namespace ServiceMap\Github;

use ServiceMap\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * @method \Github\Api\CurrentUser currentUser()
 * @method \Github\Api\CurrentUser me()
 * @method \Github\Api\Enterprise ent()
 * @method \Github\Api\Enterprise enterprise()
 * @method \Github\Api\GitData git()
 * @method \Github\Api\GitData gitData()
 * @method \Github\Api\Gists gist()
 * @method \Github\Api\Gists gists()
 * @method \Github\Api\Issue issue()
 * @method \Github\Api\Issue issues()
 * @method \Github\Api\Markdown markdown()
 * @method \Github\Api\Notification notification()
 * @method \Github\\Github\Api\Notification notifications()
 * @method \Github\Api\Organization organization()
 * @method \Github\Api\Organization organizations()
 * @method \Github\Api\Organization\Projects orgProject()
 * @method \Github\Api\Organization\Projects orgProjects()
 * @method \Github\Api\Organization\Projects organizationProject()
 * @method \Github\Api\Organization\Projects organizationProjects()
 * @method \Github\Api\PullRequest pr()
 * @method \Github\Api\PullRequest pullRequest()
 * @method \Github\Api\PullRequest pullRequests()
 * @method \Github\Api\RateLimit rateLimit()
 * @method \Github\Api\Repo repo()
 * @method \Github\Api\Repo repos()
 * @method \Github\Api\Repo repository()
 * @method \Github\Api\Repo repositories()
 * @method \Github\Api\Search search()
 * @method \Github\Api\Organization team()
 * @method \Github\Api\Organization teams()
 * @method \Github\Api\User user()
 * @method \Github\Api\User users()
 * @method \Github\Api\Authorizations authorization()
 * @method \Github\Api\Authorizations authorizations()
 * @method \Github\Api\Meta meta()
 * @method \Github\Api\ApiInterface api(string $name)
 * @method void authenticate(string $tokenOrLogin, string|null $password = null, string|null $authMethod = null)
 * @method void setEnterpriseUrl(string $enterpriseUrl)
 * @method \Github\HttpClient\HttpClientInterface getHttpClient()
 * @method void setHttpClient(\Github\HttpClient\HttpClientInterface $httpClient)
 * @method void clearHeaders()
 * @method void setHeaders(array $headers)
 * @method mixed getOption(string $name)
 * @method void setOption(string $name, mixed $value)
 * @method array getSupportedApiVersions()
 */

class GithubManager extends AbstractManager
{
  /**
   * The factory instance.
   *
   * @var \ServiceMap\Github\GithubFactory
   */
  protected $factory;

  /**
   * Create a new github manager instance.
   *
   * @param \Illuminate\Contracts\Config\Repository $config
   * @param \ServiceMap\Github\GithubFactory        $factory
   *
   * @return void
   */
  public function __construct(Repository $config, GithubFactory $factory)
  {
    parent::__construct($config);
    $this->factory = $factory;
  }

  /**
   * Create the connection instance.
   *
   * @param string $config
   *
   * @return \Github\Client
   */
  protected function createConnection(array $config)
  {
    return $this->factory->make($config);
  }

  /**
   * Get the configuration name.
   *
   * @return string
   */
  protected function getConfigName()
  {
    return 'github';
  }

  /**
   * Get the factory instance.
   *
   * @return \ServiceMap\Github\GithubFactory
   */
  public function getFactory()
  {
    return $this->factory;
  }
}
