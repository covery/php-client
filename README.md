# Covery Client

[![Latest Stable Version](https://img.shields.io/packagist/v/covery/client.svg?style=flat-square)](https://packagist.org/packages/covery/client)
[![Build Status](https://img.shields.io/travis/covery/php-client.svg?style=flat-square)](https://travis-ci.org/covery/php-client)
[![Code Quality](https://img.shields.io/scrutinizer/g/covery/php-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/covery/php-client/)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D5.4-blue.svg?style=flat-square)](http://php.net/)

Official PHP Covery Client

* [How to Start](#howto)
* [Basic Integration](#basic)
* Internals
  * [Facade](#facade)
  * [PSR-3 logging](#psr) [PSR-4 autoloading](#psr) and [PSR-7 HTTP messages](#psr)
  * [Transports](#transports)
  * [Health check](#ping)
  * [Envelopes](#envelopes)
  * [Results](#results)
  * [Exceptions](#exceptions)
* [Changelog](#changelog)

<a name="howto"></a>
# How to Start

1. You need to acquire an access token and a secret
2. Install a client using composer: `composer require "covery/client=^1.0.0"`

<a name="basic"></a>
# Basic Integration

The first thing you need is to initialize `Facade` with credentials and transport. 
To do this, place the following code somewhere close to your application initialization:

```php
use Covery\Client\Facade;
use Covery\Client\Transport\Curl;

$connectTimeoutSeconds = 5.0;
$requestTimeoutSeconds = 2.0;
Facade::setTransport(new Curl($connectTimeoutSeconds, $requestTimeoutSeconds));
Facade::setCredentials('<token>', '<secret>');
```

That's all!

Having completed this procedure, you can now query Covery using `Facade::sendEvent`, `Facade::sendPostback`, `Facade::makeDecision`.
You can test connectivity problems and token/secret validity using `Facade::ping` request.

Login event example:

```php
use Covery\Client\Envelopes\Builder;
use Covery\Client\Facade;
use Covery\Client\Identities\Stub;

$event = Builder::loginEvent(md5($userId), (string)$userId, time(), 'foo@bar.com', false) // Using builder
    ->addIdentity(new Stub())                                                             // stub identity
    ->build();                                                                            // building envelope

$result = Facade::makeDecision($event);
if ($result->isReject()) {
    // ...
}
```
Postback event example:

```php
use Covery\Client\Envelopes\Builder;
use Covery\Client\Facade;

$event = Builder::postbackEvent($requestId, null, 'code', 'reason')->build(); // postback for event with id $requestId
$postbackRequestId = Facade::sendPostback($event);
```


# Tech Details

<a name="facade"></a>
## Facade

`Covery\Client\Facade` is a static wrapper over `Covery\Client\PublicAPIClient`. If you use dependency injection
or other application assembly mechanism, you may prefer not to use `Facade`, and rather use the client directly.

<a name="psr"></a>
## PSR-3, PSR-4 and PSR7

1. Covery client supports PSR-3 loggers. You may assign them to `Facade` calling `Facade::setLogger` or to `PublicAPIClient` passing a logger as a constructor argument.
2. Covery client code uses PSR-4 autoloader. Just require `/vendor/autoload.php`.
3. HTTP communication uses PSR-7 HTTP message, so you may extend the client's capabilities as you see fit.

<a id="transports"></a>
## Transports

Covery client may use any class that satisfies `Covery\Client\TransportInterface` to send requests. Covery client ships with two major implementations:

1. `Covery\Client\Transport\Curl` - simple PHP curl implementation
2. `Covery\Client\Transport\OverGuzzle` - adapter over [Guzzle](https://github.com/guzzle/guzzle) HTTP client

<a name="ping"></a>
## Health Check

To perform network accessibility and token validity tests, run `ping()` method inside `Facade`
or `PublicAPIClient`. It will throw an exception on any problems or return your token access level on success. 
In most cases it will return `"DECISION"` as your token level.

<a name="envelopes"></a>
## Envelopes

Methods `sendEvent` and `makeDecision` require envelope as argument. Envelope is a pack of following data:

* `SequenceID` - Event grouping identifier. Covery will attempt to group events using this field. It is recommended to use 
   userID as a sequence ID. However, Covery requires a long string (6-40 characters) in this field, so you may use `md5($userId)` as `SequenceID` for better results.
* `Identities` - List of identities this event belongs to. For most cases a single `Identities\Stub` is enough.
* `Type` - Event type, one of:
  * `install` - install event
  * `registration` - registration event
  * `confirmation` - registration confirmation event, must have the same `SequenceID` with registration event
  * `login` - login event, must have the same `SequenceID` with registration event
  * `transaction` - payment event, must have the same `SequenceID` with registration and login events
  * `refund` - refund event
  * `payout` - payout event
  * `transfer` - transfer event
  * `kyc_profile` - kyc profile event
  * `kyc_submit` - kyc submit event
  
Envelope specifications are bundled in `Covery\Client\EnvelopeInterface`.

You may provide the following as envelopes:

1. Own implementations of `EnvelopeInterface`. For example, your own payment order model may be extended to implement `EnvelopeInterface`, then you may pass it to `sendEvent` and/or `makeDecision` directly.
2. Custom-built `Covery\Client\Envelopes\Envelope`
3. Envelopes built using `Covery\Client\Envelopes\Builder` (don't forget to invoke `build()`!)

<a name="results"></a>
## Results

1. `ping` will return `string` containing current token access level on success.
2. `sendEvent` will return `integer` (may be x64) containing ID of a stored entity on Covery side. You should log it.
3. `makeDecision` will return `Covery\Client\Result` object:
   * Call `getScore()` to obtain score in range [-100, 100]
   * Method `isAccept()` will return `true` if Covery did not found fraud in incoming envelope data
   * Method `isReject()` will return `true` if Covery found fraud in incoming envelope data

<a name="exceptions"></a>
## Exception Tree

* `Covery\Client\Exception` - base exception
  * `Covery\Client\EnvelopeValidationException` - thrown if envelope failed client side validation
  * `Covery\Client\DeliveredException` - exception delivered for Covery server
    * `Covery\Client\AuthException` - authorization exception
  * `Covery\Client\IoException` - server communication error
    * `Covery\Client\TimeoutException` - timeout


<a name="changelog"></a>
## Changelog
* `1.2.0`
  * Added support for request timeouts
* `1.1.9`
  * Added optional `bic` field for transfer event  
* `1.1.8`
  * Added slash before request path (guzzle deprecation since version 1.4) 
* `1.1.7`
  * Added `kyc_profile`, `kyc_submit` events
* `1.1.6`
  * Added decision response fields: `type`, `createdAt`, `sequenceId`, `merchantUserId`, `reason`, `action` and custom response
* `1.1.5`
  * Postback request_id change type to `int`
* `1.1.4`
  * Malformed error for empty postback response
* `1.1.3`
  * Postback request with request_id or transaction_id 
* `1.1.2`
  * added sendPostback method to send posback events
* `1.1.1`
  * added optional `password` for login, registration events
  * added optional `iban`, `second_iban` for transfer event
* `1.1.0`
  * added optional `local_ip_list`, `plugins`, `referer_url`, `origin_url`, `client_resolution` for browser data
  * added optional `email`, `phone`, `user_merchant_id` for refund event
* `1.0.9`
  * new `transfer` event introduced
* `1.0.8`
  * added optional `traffic_source` and `affiliate_id` for login event
* `1.0.7`
  * custom fields validation fixed
* `1.0.6`
  * string validation actualized
* `1.0.5`
  *  new `postback` event introduced
  *  added optional `gender` for login event
  *  added optional `payout_account_id` for payout event
  * `payout_card_id`, `payout_ammount_converted` moved to optional for payout event
  *  added optional `affiliate_id` for transaction event
  *  added optional `refund_method`, `refund_system`, `refund_mid` for refund event
  *  added `device_id` to all packets
  *  tests for `postback` event added
  *  old tests modified
* `1.0.4`
  *  new `install`, `refund` events introduced
  * `transaction_mode` moved to optional for transaction event
  *  added mandatory `user_merchant_id` for transaction event
  *  tests for `install`, `refund`, `transaction` events added
  *  payout test fixed
* `1.0.3`
  * new `payout` event introduced
  * identity nodes are optional now
  * new experimental `PersistentCurl` transport for workers
* `1.0.2` cURL issue with status code 100 fixed
* `1.0.1`
  * added optional `email` and `phone` to confirmation event
  * added more optional fields to all packets: `ajax_validation`, `cookie_enabled`, `cpu_class`, `device_fingerprint`, 
    `do_not_track`, `ip`, `language`, `language_browser`, `language_system`, `language_user`, `languages`, `os`, 
    `real_ip`, `screen_orientation`, `screen_resolution`, `timezone_offset`, `user_agent`
* `1.0.0` - release
