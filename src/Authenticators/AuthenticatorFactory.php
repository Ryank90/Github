<?php

namespace ServiceMap\Github\Authenticators;

use InvalidArgumentException;

class AuthenticatorFactory
{
  /**
   * Make a new authenticator instance.
   *
   * @param string $method
   *
   * @return \ServiceMap\Github\Authenticators\AuthenticatorInterface
   */
  public function make($method)
  {
    switch ($method) {
      case 'application':
        return new ApplicationAuthenticator();
      case 'password':
        return new PasswordAuthenticator();
      case 'token':
        return new TokenAuthenticator();
    }

    throw new InvalidArgumentException('Unsupported authentication method [' . $method . '].');
  }
}
