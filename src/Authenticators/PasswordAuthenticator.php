<?php

namespace ServiceMap\Github\Authenticators;

use InvalidArgumentException;

class PasswordAuthenticator extends AbstractAuthenticator implements AuthenticatorInterface
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
       throw new InvalidArgumentException('The client instance was not given to the password authenticator.');
     }

     if (!array_key_exists('username', $config) || !array_key_exists('password', $config)) {
       throw new InvalidArgumentException('The password authenticator requires a username and password.');
     }

     $this->client->authenticate($config['username'], $config['password'], 'http_password');

     return $this->client;
  }
}
