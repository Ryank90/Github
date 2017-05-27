<?php

namespace ServiceMap\Github\Authenticators;

use Github\Client;

interface AuthenticatorInterface
{
  /**
   * Set the client to perform the authentication on.
   *
   * @param \Github\Client $client
   *
   * @return \ServiceMap\Github\Authenticators\AuthenticatorInterface
   */
  public function with(Client $client);

  /**
   * Authenticate the client, and return it.
   *
   * @param string[] $config
   *
   * @throws \InvalidArgumentException
   *
   * @return \Github\Client
   */
  public function authenticate(array $config);
}
