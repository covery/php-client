# Covery client

Official PHP Covery client

[![Latest Stable Version](https://img.shields.io/packagist/v/covery/client.svg?style=flat-square)](https://packagist.org/packages/covery/client)
[![Build Status](https://img.shields.io/travis/covery/php-client.svg?style=flat-square)](https://travis-ci.org/covery/php-client)
[![Code quality](https://img.shields.io/scrutinizer/g/covery/php-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/covery/php-client/)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.4-blue.svg?style=flat-square)](http://php.net/)

# How to start

1. Acquire access token and secret
2. Install client using composer: `composer require "covery/client=^1.0.0"`

# Basic integration

First thing you need - initialize `Facade` with credentials and transport. 
To do this, place following code somewhere near your application initialization:

```php
use Covery\Client\Facade;
use Covery\Client\Credentials\Sha256;
use Covery\Client\Transport\Curl;

Facade::setTransport(new Curl(5.0 /* Timeout */));
Facade::setCredentials(new Sha256('<token>', '<secret>'));
```

Thats all!

After this simple step you can query Covery using `Facade::sendEvent` or `Facade::makeDecision`.
Connectivity problems and token/secret validity you can test using `Facade::ping` request.

Login event example:

```php
use Covery\Client\Envelopes\Builder;
use Covery\Client\Facade;
use Covery\Client\Identities\Stub;

$event = Builder::loginEvent(md5($userId), string($userId), time(), 'foo@bar.com', false) // Using builder
    ->addIdentity(new Stub())                                                             // stub identity
    ->build();                                                                            // building envelope

$result = Facade::makeDecision($event);
if ($result->isReject()) {
    // ...
}
```

# Tech details

## PSR-3, PSR-4 and PSR7

1. Covery client supports PSR-3 loggers. You may assign it to `Facade` using `Facade::setLogger` or to `PublicAPIClient`, using corresponding argument in constructor
2. Covery client code uses PSR-4 autoloader. Just require `/vendor/autoload.php`
3. All HTTP communication uses PSR-7 HTTP message, so it is pretty easy to extend client capatibilities

## Transports

Covery client may use any class, that satisfies `Covery\Client\TransportInterface`, to send requests. Covery client ships with two major implementations:

1. `Covery\Client\Transport\Curl` - simple PHP curl implementation
2. `Covery\Client\Transport\OverGuzzle` - adapter over [Guzzle](https://github.com/guzzle/guzzle) HTTP client
