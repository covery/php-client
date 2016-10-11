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

## Facade

`Covery\Client\Facade` is static wrapper over `Covery\Client\PublicAPIClient`, so if you are using dependency injection
or other application assembly logic, you may ignore `Facade` at all.

## PSR-3, PSR-4 and PSR7

1. Covery client supports PSR-3 loggers. You may assign it to `Facade` using `Facade::setLogger` or to `PublicAPIClient`, using corresponding argument in constructor
2. Covery client code uses PSR-4 autoloader. Just require `/vendor/autoload.php`
3. All HTTP communication uses PSR-7 HTTP message, so it is pretty easy to extend client capatibilities

## Transports

Covery client may use any class, that satisfies `Covery\Client\TransportInterface`, to send requests. Covery client ships with two major implementations:

1. `Covery\Client\Transport\Curl` - simple PHP curl implementation
2. `Covery\Client\Transport\OverGuzzle` - adapter over [Guzzle](https://github.com/guzzle/guzzle) HTTP client

## Health check

To perform network accessibility and token validity tests, you must run `ping()` method inside `Facade`
or `PublicAPIClient`. It will throw an exception on any problems or return your token access level on success. 
In most cases, it will return `"DECISION"` as your token level.

## Envelopes

Methods `sendEvent` and `makeDecision` requires envelope as argument. Envelope - is pack of following data:

* `SequenceID` - Event grouping identifier. Using this field, Covery will attempt to group events. Recommended contents - 
   userID, but Covery requires long string in this field, so you may use `md5($userId)` as `SequenceID` for
   better results.
* `Identities` - List of identities this event belongs to. For most cases single `Identities\Stub` is enough.
* `Type` - Event type, one of:
  * `registration` - registration event
  * `confirmation` - registration confirmation event, must have same `SequenceID` with registration event
  * `login` - login event, must have same `SequenceID` with registration event
  * `transaction` - payment event, must have same `SequenceID` with registration and login events
  
All envelope specifications are bundled in `Covery\Client\EnvelopeInterface`.

You may provide as envelopes:

1. Own implementations of `EnvelopeInterface`. For example, you make take your own payment order model, make it
   implement `EnvelopeInterface` and then just pass it to `sendEvent` and/or `makeDecision`.
2. Custom built `Covery\Client\Envelopes\Envelope`
3. Envelopes built using `Covery\Client\Envelopes\Builder` (dont forget to invoke `build()` !)

## Results

1. `ping` will return `string` containing current token access level on success
2. `sendEvent` will return `integer` (may be x64) containing ID of stored entity on Covery side. Log it
3. `makeDecision` will return `Covery\Client\Result` object:
   * Call `getScore()` to obtain score in range [-100, 100]
   * Method `isAccept()` will return `true` if covery did not found fraud in incoming envelope data
   * Method `isReject()` will return `true` if covery found fraud in incoming envelope data

## Exception tree

* `Covery\Client\Exception` - base exception for all others
  * `Covery\Client\EnvelopeValidationException` - thrown if envelope failed client side validation
  * `Covery\Client\DeliveredException` - exception, delivered for Covery server
    * `Covery\Client\AuthException` - authorization exception
  * `Covery\Client\IoException` - server communication error
    * `Covery\Client\TimeoutException` - timeout