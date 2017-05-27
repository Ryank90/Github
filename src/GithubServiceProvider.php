<?php

namespace ServiceMap\Github;

use Github\Client;
use ServiceMap\Github\Authenticators\AuthenticatorFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
  /**
   * Boot the service provider.
   *
   * @return void
   */
  public function boot()
  {
    $this->setupConfig();
  }

  /**
   * Setup the config.
   *
   * @return void
   */
  protected function setupConfig()
  {
    $source = realpath(__DIR__.'/../config/github.php');
    if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
      $this->publishes([$source => config_path('github.php')]);
    }

    $this->mergeConfigFrom($source, 'github');
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->registerAuthFactory();
    $this->registerGithubFactory();
    $this->registerManager();
    $this->registerBindings();
  }

  /**
   * Register the auth factory class.
   *
   * @return void
   */
  protected function registerAuthFactory()
  {
    $this->app->singleton('github.authfactory', function () {
      return new AuthenticatorFactory();
    });

    $this->app->alias('github.authfactory', AuthenticatorFactory::class);
  }

  /**
   * Register the github factory class.
   *
   * @return void
   */
  protected function registerGithubFactory()
  {
    $this->app->singleton('github.factory', function (Container $app) {
      $auth = $app['github.authfactory'];
      $cache = $app['cache'];

      return new GithubFactory($auth, $cache);
    });

    $this->app->alias('github.factory', GithubFactory::class);
  }

  /**
   * Register the manager class.
   *
   * @return void
   */
  protected function registerManager()
  {
    $this->app->singleton('github', function (Container $app) {
      $config = $app['config'];
      $factory = $app['github.factory'];

      return new GithubManager($config, $factory);
    });

    $this->app->alias('github', GithubManager::class);
  }

  /**
   * Register the bindings.
   *
   * @return void
   */
  protected function registerBindings()
  {
    $this->app->bind('github.connection', function (Container $app) {
      $manager = $app['github'];

      return $manager->connection();
    });

    $this->app->alias('github.connection', Client::class);
  }

  /**
   * Get the services provided by the provider.
   *
   * @return string[]
   */
  public function provides()
  {
    return [
      'github.authfactory',
      'github.factory',
      'github',
      'github.connection',
    ];
  }
}
