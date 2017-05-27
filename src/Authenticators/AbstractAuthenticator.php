<?php

namespace ServiceMap\Github\Authenticators;

use Github\Client;

abstract class AbstractAuthenticator
{
  /**
   * The client to perform the authentication on.
   *
   * @var \Github\Client|null
   */
  protected $client;

  /**
   * Set the client to perform the authentication on.
   *
   * @param \Github\Client $client
   *
   * @return \ServiceMap\Github\Authenticators\AuthenticatorInterface
   */
  public function with(Client $client)
  {
    $this->client = $client;

    return $this;
  }
}
