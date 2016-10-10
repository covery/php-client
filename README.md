# Covery client

[![Latest Stable Version](https://img.shields.io/packagist/v/covery/client.svg?style=flat-square)](https://packagist.org/packages/covery/client)
[![Build Status](https://img.shields.io/travis/covery/php-client.svg?style=flat-square)](https://travis-ci.org/covery/php-client)
[![Code quality](https://img.shields.io/scrutinizer/g/covery/php-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/covery/php-client/)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.4-blue.svg?style=flat-square)](http://php.net/)

# Installation 

Best way to use client - require it with composer

```bash
composer require "covery/client=^1.0.0"
```

# Usage 

The first thing you need - acquire access token.
After that you can start integration process

## Static integration

Place following code anywhere near configuration

```php
\Covery\Client\Facade::setCredentials(new \Covery\Client\Credentials\Sha256('<token>', '<secret>'));
\Covery\Client\Facade::setTransport(new \Covery\Client\Transport\OverGuzzle(new GuzzleHttp\Client()));
```

Then, place `Facade` invocation in event place. For example, login event:

```php
$envelopeBuilder = \Covery\Client\Envelopes\Builder::loginEvent(
  md5($userId),
  $userId,
  time(),
  $email,
  $loginFailed
)->addIdentity(new Stub());
$result = \Covery\Client\Facade::makeDecision($envelopeBuilder->build());
if ($result->isReject()) {
  // Some logic goes here
}
```