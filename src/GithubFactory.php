<?php

namespace ServiceMap\Github;

use Github\Client;
use Github\HttpClient\Builder;
use ServiceMap\Github\Authenticators\AuthenticatorFactory;
use Http\Client\Common\Plugin\RetryPlugin;
use Illuminate\Contracts\Cache\Factory;
use Madewithlove\IlluminatePsrCacheBridge\Laravel\CacheItemPool;

class GithubFactory
{
  /**
   * The authenticator factory instance.
   *
   * @var \ServiceMap\Github\Authenticators\AuthenticatorFactory
   */
  protected $auth;

  /**
   * The illuminate cache instance.
   *
   * @var \Illuminate\Contracts\Cache\Factory|null
   */
  protected $cache;

  /**
   * Create a new github factory instance.
   *
   * @param \ServiceMap\Github\Authenticators\AuthenticatorFactory $auth
   * @param \Illuminate\Contracts\Cache\Factory|null               $cache
   *
   * @return void
   */
  public function __construct(AuthenticatorFactory $auth, Factory $cache = null)
  {
    $this->auth = $auth;
    $this->cache = $cache;
  }

  /**
   * Make a new github client.
   *
   * @param string[] $config
   *
   * @return \Github\Client
   */
  public function make(array $config)
  {
    $client = new Client($this->getBuilder($config), array_get($config, 'version'), array_get($config, 'enterprise'));

    return $this->auth->make(array_get($config, 'method'))->with($client)->authenticate($config);
  }

  /**
   * Get the http client builder.
   *
   * @param string[] $config
   *
   * @return \Github\HttpClient\Builder
   */
  protected function getBuilder(array $config)
  {
    $builder = new Builder();

    if ($backoff = array_get($config, 'backoff')) {
      $builder->addPlugin(new RetryPlugin(['retries' => $backoff === true ? 2 : $backoff]));
    }

    if ($this->cache && class_exists(CacheItemPool::class) && $cache = array_get($config, 'cache')) {
      $builder->addCache(new CacheItemPool($this->cache->store($cache === true ? null : $cache)));
    }

    return $builder;
  }
}
