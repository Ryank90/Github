<?php

namespace ServiceMap\Github\Authenticators;

use InvalidArgumentException;

class ApplicationAuthenticator extends AbstractAuthenticator implements AuthenticatorInterface
{
  /**
   * Authenticate the client, and return it.
   *
   * @param string[] $config
   *
   * @throws \InvalidArgumentException
   *
   * @return \Github\Client
   */
  public function authenticate(array $config)
  {
    if (!$this->client) {
      throw new InvalidArgumentException('The client instance was not given to the application authenticator.');
    }

    if (!array_key_exists('clientId', $config) || !array_key_exists('clientSecret', $config)) {
      throw new InvalidArgumentException('The application authenticator requires a client id and secret.');
    }

    $this->client->authenticate($config['clientId'], $config['clientSecret'], 'url_client_id');

    return $this->client;
  }
}
