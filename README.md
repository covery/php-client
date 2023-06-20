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
  * [Envelopes](#envelopes)
  * [Results](#results)
  * [Exceptions](#exceptions)
  * [Error loggers](#loggers)
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

Optional (use only for debug):
```php
use Covery\Client\Loggers\FileLogger;

//directory must be writable!
$filePath = "path_to_file/error.log";

Facade::setLogger(new FileLogger($filePath));
```

That's all!

Having completed this procedure, you can now query Covery using `Facade::sendEvent`, `Facade::sendPostback`, `Facade::makeDecision`.

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
Postback event example:

```php
use Covery\Client\Envelopes\Builder;
use Covery\Client\Facade;

$event = Builder::postbackEvent($requestId, null, 'code', 'reason')->build(); //postbcak for event with id $requestId
$postbackRequestId = Facade::sendPostback($event);
```

KycProof event example:

```php
use Covery\Client\Envelopes\Builder;
use Covery\Client\Facade;

$event = Builder::kycProofEvent($kycStartId)->build();
$kycProofData = Facade::sendKycProof($event);
```

Card Id event example:
```php
use Covery\Client\CardId\Builder;
use Covery\Client\Facade;

$event = Builder::cardIdEvent('curdNumber')->build();
$result = Facade::sendCardId($event);
```

Media Storage event example:
```php
use Covery\Client\MediaStorage\Builder;
use Covery\Client\Facade;

$event = Builder::mediaStorageEvent(\Covery\Client\ContentType::JPEG, \Covery\Client\ContentDescription::GENERAL_DOCUMENT, null, false)->build();
$result = Facade::sendMediaStorage($event);
```

Attach media connection event example:
```php
use Covery\Client\MediaConnection\Builder;
use Covery\Client\Facade;

$event = Builder::mediaConnectionEvent(1, [1])->build();
$result = Facade::attachMediaConnection($event);
```

Detach media connection event example:
```php
use Covery\Client\MediaConnection\Builder;
use Covery\Client\Facade;

$event = Builder::mediaConnectionEvent(1, [1])->build();
$result = Facade::detachMediaConnection($event);
```

Media file upload example:
```php
use Covery\Client\Facade;

$stream = fopen('PATH_TO_FILE', 'r');
$mediaUrl = 'UPLOAD_URL'; //URL from Covery
$mediaFileUploader = \Covery\Client\MediaFileUploader\Builder::mediaFileUploaderEvent(
    $mediaUrl,
    $fileStream
)->build();

$result = \Covery\Client\Facade::uploadMediaFile($mediaFileUploader);
```

Account Configuration Status event example:
```php
use Covery\Client\Facade;

$accountConfigurationStatus = Facade::getAccountConfigurationStatus();
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
  * `order_item` - order item event
  * `order_submit` - order submit event
  
Envelope specifications are bundled in `Covery\Client\EnvelopeInterface`.

You may provide the following as envelopes:

1. Own implementations of `EnvelopeInterface`. For example, your own payment order model may be extended to implement `EnvelopeInterface`, then you may pass it to `sendEvent` and/or `makeDecision` directly.
2. Custom-built `Covery\Client\Envelopes\Envelope`
3. Envelopes built using `Covery\Client\Envelopes\Builder` (don't forget to invoke `build()`!)

<a name="results"></a>
## Results

1. `sendEvent` will return `integer` (may be x64) containing ID of a stored entity on Covery side. You should log it.
2. `makeDecision` will return `Covery\Client\Result` object:
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

<a name="loggers"></a>
## Error loggers
* `\Covery\Client\Loggers\VarDumpLogger` - simple var_dump logger
* `\Covery\Client\Loggers\FileLogger` - writing errors to a file
* You can also write your own logger class extended from AbstractLogger


<a name="changelog"></a>
## Changelog
* `1.3.14` Added MediaStorage method. Added MediaConnection method. Added UploadMediaFile method.
  * Added optional `media_id` field for events: install, registration, confirmation, login, order-item, order-submit, transaction, refund, payout, transfer, profile-update, kyc-profile, kyc-submit.
  * Added optional address_confirmed, second_address_confirmed fields for KYC profile and KYC submit events.
  * Added AccountConfigurationStatus method.
  * Removed Health check method.
* `1.3.13` Added StaleDataException exception 
* `1.3.12` Added sendCardId method
* `1.3.11` Added VarDumpLogger and FileLogger
* `1.3.10`
  * Removed the limit on the number of custom fields in the request
* `1.3.9`
  * Added optional `provider_id`, `profile_id`, `profile_type`,
  `profile_sub_type`, `firstname`, `lastname`, `fullname`, `gender`,
  `industry`, `wallet_type`, `website_url`, `description`,
  `employment_status`, `source_of_funds`, `birth_date`, `reg_date`,
  `issue_date`, `expiry_date`, `reg_number`, `vat_number`, `email`,
  `email_confirmed`, `phone`, `phone_confirmed`, `contact_email`,
  `contact_phone`, `country`, `state`, `city`, `address`, `zip`,
  `nationality`, `second_country`, `second_state`, `second_city`,
  `second_address`, `second_zip`, `ajax_validation`, `cookie_enabled`,
  `cpu_class`, `device_fingerprint`, `device_id`, `do_not_track`,
  `ip`, `real_ip`, `local_ip_list`, `language`, `languages`,
  `language_browser`, `language_user`, `language_system`, `os`,
  `screen_resolution`, `screen_orientation`, `client_resolution`,
  `timezone_offset`, `user_agent`, `plugins`, `referer_url`,
  `origin_url` fields for kyc_submit event.
* `1.3.8`
  * Added optional `links_to_documents` field for transaction, refund, payout, transfer, profile_update, kyc_profile and kyc_submit events
* `1.3.7`
  * Added `profile_update` event
* `1.3.6`
  * Added optional `allowed_document_format` field for kyc_start event.
* `1.3.5`
  * Added optional `second_user_merchant_id` field for transfer event
* `1.3.4`
  * Added optional `number_of_documents` field for kyc_start event.
  * Added `kyc_proof` event
* `1.3.3`
  * Added optional `provider_id`, `contact_email`, `contact_phone`, `wallet_type`, `nationality`, `final_beneficiary`, `employment_status`, `source_of_funds`, `issue_date`, `expiry_date`, `gender` fields for kyc_profile event.
  * Added `kyc_start` event.
* `1.3.2`
  * Added optional `merchant_country`, `mcc`, `acquirer_merchant_id` fields for transaction event. Added optional `group_id` field for install, registration, confirmation, login, transaction, refund, payout and transfer events
* `1.3.1`
  * Added `order_item`, `order_submit` events. Added optional `transfer_source` field for transfer event
* `1.3.0`
  * Added optional `campaign` field for login, registration, install and transaction events
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
