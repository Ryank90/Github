<?php

namespace ServiceMap\Github\Authenticators;

use InvalidArgumentException;

class TokenAuthenticator extends AbstractAuthenticator implements AuthenticatorInterface
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
      throw new InvalidArgumentException('The client instance was not given to the token authenticator.');
    }

    if (!array_key_exists('token', $config)) {
      throw new InvalidArgumentException('The token authenticator requires a token.');
    }

    $this->client->authenticate($config['token'], 'http_token');

    return $this->client;
  }
}
