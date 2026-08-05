<?php

namespace Covery\Client\Envelopes;

use Covery\Client\DocumentType;
use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

/**
 * Envelope builder methods split out of Builder to reduce its size.
 */
trait UserBuilder
{
    /**
     * Provides website URL to envelope
     *
     * @param string|null $websiteUrl
     * @param string|null $traffic_source
     * @param string|null $affiliate_id
     * @param string|null $campaign
     *
     * @return $this
     */
    public function addWebsiteData($websiteUrl = null, $traffic_source = null, $affiliate_id = null, $campaign = null)
    {
        $this->assertOptionalString($websiteUrl, 'Website URL must be string');
        $this->assertOptionalString($traffic_source, 'Traffic source must be string');
        $this->assertOptionalString($affiliate_id, 'Affiliate ID must be string');
        $this->assertOptionalString($campaign, 'Campaign must be string');

        $this->replace('website_url', $websiteUrl);
        $this->replace('traffic_source', $traffic_source);
        $this->replace('affiliate_id', $affiliate_id);
        $this->replace('campaign', $campaign);
        return $this;
    }

    /**
     * Provides IP information for envelope
     *
     * @param string|null $ip User's IP address
     * @param string|null $realIp User's real IP address, if available
     * @param string|null $merchantIp Your website's IP address
     *
     * @return $this
     */
    public function addIpData($ip = '', $realIp = '', $merchantIp = '')
    {
        $this->assertOptionalString($ip, 'IP must be string');
        $this->assertOptionalString($realIp, 'Real IP must be string');
        $this->assertOptionalString($merchantIp, 'Merchant IP must be string');

        $this->replace('ip', $ip);
        $this->replace('real_ip', $realIp);
        $this->replace('merchant_ip', $merchantIp);

        return $this;
    }

    /**
     * Provides browser information for envelope
     *
     * @param string|null $deviceFingerprint
     * @param string|null $userAgent
     * @param string|null $cpuClass
     * @param string|null $screenOrientation
     * @param string|null $screenResolution
     * @param string|null $os
     * @param int|null $timezoneOffset
     * @param string|null $languages
     * @param string|null $language
     * @param string|null $languageBrowser
     * @param string|null $languageUser
     * @param string|null $languageSystem
     * @param bool|null $cookieEnabled
     * @param bool|null $doNotTrack
     * @param bool|null $ajaxValidation
     * @param string|null $deviceId
     * @param string|null $ipList
     * @param string|null $plugins
     * @param string|null $refererUrl
     * @param string|null $originUrl
     * @param string|null $clientResolution
     * @param bool|null $anonymous
     * @return $this
     */
    public function addBrowserData(
        $deviceFingerprint = '',
        $userAgent = '',
        $cpuClass = '',
        $screenOrientation = '',
        $screenResolution = '',
        $os = '',
        $timezoneOffset = null,
        $languages = '',
        $language = '',
        $languageBrowser = '',
        $languageUser = '',
        $languageSystem = '',
        $cookieEnabled = null,
        $doNotTrack = null,
        $ajaxValidation = null,
        $deviceId = '',
        $ipList = null,
        $plugins = null,
        $refererUrl = null,
        $originUrl = null,
        $clientResolution = null,
        $anonymous = null
    ) {
        $this->assertOptionalString($deviceFingerprint, 'Device fingerprint must be string');
        $this->assertOptionalString($userAgent, 'User agent must be string');
        $this->assertOptionalString($cpuClass, 'CPU class must be string');
        $this->assertOptionalString($screenOrientation, 'Screen orientation must be string');
        $this->assertOptionalString($screenResolution, 'Screen resolution must be string');
        $this->assertOptionalString($os, 'OS must be string');
        $this->assertOptionalInt($timezoneOffset, 'Timezone offset must be integer or null');
        $this->assertOptionalString($languages, 'Languages must be string');
        $this->assertOptionalString($language, 'Language must be string');
        $this->assertOptionalString($languageBrowser, 'Browser language must be string');
        $this->assertOptionalString($languageUser, 'User language must be string');
        $this->assertOptionalString($languageSystem, 'System language must be string');
        $this->assertOptionalBool($cookieEnabled, 'Cookie enabled flag must be boolean');
        $this->assertOptionalBool($doNotTrack, 'DNT flag must be boolean');
        $this->assertOptionalBool($anonymous, 'Anonymous flag must be boolean');
        $this->assertOptionalBool($ajaxValidation, 'AJAX validation flag must be boolean');
        $this->assertOptionalString($deviceId, 'Device id must be string');
        $this->assertOptionalString($ipList, 'Ip list must be string');
        $this->assertOptionalString($plugins, 'Plugins must be string');
        $this->assertOptionalString($refererUrl, 'Referer url must be string');
        $this->assertOptionalString($originUrl, 'Origin url must be string');
        $this->assertOptionalString($clientResolution, 'Client resolution must be string');

        $this->replace('device_fingerprint', $deviceFingerprint);
        $this->replace('user_agent', $userAgent);
        $this->replace('cpu_class', $cpuClass);
        $this->replace('screen_orientation', $screenOrientation);
        $this->replace('screen_resolution', $screenResolution);
        $this->replace('os', $os);
        $this->replace('timezone_offset', $timezoneOffset);
        $this->replace('languages', $languages);
        $this->replace('language', $language);
        $this->replace('language_browser', $languageBrowser);
        $this->replace('language_system', $languageSystem);
        $this->replace('language_user', $languageUser);
        $this->replace('cookie_enabled', $cookieEnabled);
        $this->replace('do_not_track', $doNotTrack);
        $this->replace('anonymous', $anonymous);
        $this->replace('ajax_validation', $ajaxValidation);
        $this->replace('device_id', $deviceId);
        $this->replace('local_ip_list', $ipList);
        $this->replace('plugins', $plugins);
        $this->replace('referer_url', $refererUrl);
        $this->replace('origin_url', $originUrl);
        $this->replace('client_resolution', $clientResolution);

        return $this;
    }

    /**
     * Provides user data for envelope
     *
     * @param string|null $email
     * @param string|null $userId
     * @param string|null $phone
     * @param string|null $userName
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $gender
     * @param int|null $age
     * @param string|null $country
     * @param string|null $socialType
     * @param int|null $registrationTimestamp
     * @param int|null $loginTimeStamp
     * @param int|null $confirmationTimeStamp
     * @param bool|null $emailConfirmed
     * @param bool|null $phoneConfirmed
     * @param bool|null $loginFailed
     * @param int|null $birthDate
     * @param string|null $fullname
     * @param string|null $state
     * @param string|null $city
     * @param string|null $address
     * @param string|null $zip
     * @param string|null $password
     *
     * @return $this
     */
    public function addUserData(
        $email = '',
        $userId = '',
        $phone = '',
        $userName = '',
        $firstName = '',
        $lastName = '',
        $gender = '',
        $age = 0,
        $country = '',
        $socialType = '',
        $registrationTimestamp = 0,
        $loginTimeStamp = 0,
        $confirmationTimeStamp = 0,
        $emailConfirmed = null,
        $phoneConfirmed = null,
        $loginFailed = null,
        $birthDate = null,
        $fullname = null,
        $state = null,
        $city = null,
        $address = null,
        $zip = null,
        $password = ''
    )
    {
        $this->assertOptionalString($userName, 'User name must be string');
        $this->assertOptionalString($password, 'Password must be string');
        $this->assertOptionalString($gender, 'Gender must be string');
        $this->assertOptionalInt($age, 'Age must be integer');
        $this->assertOptionalString($socialType, 'Social type must be string');
        $this->assertOptionalInt($registrationTimestamp, 'Registration timestamp must be integer');
        $this->assertOptionalInt($loginTimeStamp, 'Login timestamp must be integer');
        $this->assertOptionalInt($confirmationTimeStamp, 'Confirmation timestamp must be integer');
        $this->assertOptionalInt($birthDate, 'Birthdate timestamp must be integer');
        $this->assertOptionalBool($emailConfirmed, 'Email confirmed flag must be boolean');
        $this->assertOptionalBool($phoneConfirmed, 'Phone confirmed flag must be boolean');
        $this->assertOptionalBool($loginFailed, 'Login failed flag must be boolean');
        $this->assertOptionalString($fullname, 'Fullname must be string');
        $this->assertOptionalString($state, 'State must be string');
        $this->assertOptionalString($city, 'City must be string');
        $this->assertOptionalString($address, 'Address must be string');
        $this->assertOptionalString($zip, 'Zip must be string');

        $this->addShortUserData($email, $userId, $phone, $firstName, $lastName, $country);

        $this->replace('user_name', $userName);
        $this->replace('gender', $gender);
        $this->replace('age', $age);
        $this->replace('social_type', $socialType);
        $this->replace('registration_timestamp', $registrationTimestamp);
        $this->replace('login_timestamp', $loginTimeStamp);
        $this->replace('confirmation_timestamp', $confirmationTimeStamp);
        $this->replace('email_confirmed', $emailConfirmed);
        $this->replace('phone_confirmed', $phoneConfirmed);
        $this->replace('login_failed', $loginFailed);
        $this->replace('birth_date', $birthDate);
        $this->replace('fullname', $fullname);
        $this->replace('state', $state);
        $this->replace('city', $city);
        $this->replace('address', $address);
        $this->replace('zip', $zip);
        $this->replace('password', $password);

        return $this;
    }

    /**
     * Provides user data for envelope
     *
     * @param string|null $email
     * @param string|null $userId
     * @param string|null $phone
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $country
     *
     * @return $this
     */
    public function addShortUserData(
        $email = '',
        $userId = '',
        $phone = '',
        $firstName = '',
        $lastName = '',
        $country = ''
    ) {
        $this->assertOptionalString($email, 'Email must be string');
        if (is_int($userId)) {
            $userId = strval($userId);
        }
        $this->assertOptionalString($userId, 'UserId must be string or integer');
        $this->assertOptionalString($phone, 'Phone must be string');
        $this->assertOptionalString($firstName, 'First name must be string');
        $this->assertOptionalString($lastName, 'Last name must be string');
        $this->assertOptionalString($country, 'Country must be string');

        $this->replace('email', $email);
        $this->replace('user_merchant_id', $userId);
        $this->replace('phone', $phone);
        $this->replace('firstname', $firstName);
        $this->replace('lastname', $lastName);
        $this->replace('country', $country);

        return $this;
    }

    /**
     * Provides Card data to envelope
     *
     * @param string|null $cardId
     * @param int|null $cardBin
     * @param string|null $cardLast4
     * @param int|null $expirationMonth
     * @param int|null $expirationYear
     *
     * @return $this
     */
    public function addCardData(
        $cardBin,
        $cardLast4,
        $expirationMonth,
        $expirationYear,
        $cardId = null
    ) {
        $this->assertOptionalString($cardId, 'Card ID must be string');
        $this->assertOptionalInt($cardBin, 'Card BIN must be integer');
        $this->assertOptionalString($cardLast4, 'Card last4  must be string');
        $this->assertOptionalInt($expirationMonth, 'Expiration month must be integer');
        $this->assertOptionalInt($expirationYear, 'Expiration year must be integer');

        $this->replace('card_id', $cardId);
        $this->replace('card_bin', $cardBin);
        $this->replace('card_last4', $cardLast4);
        $this->replace('expiration_month', $expirationMonth);
        $this->replace('expiration_year', $expirationYear);

        return $this;
    }

    /**
     * Provides billing data to envelope
     *
     * @param string|null $billingFirstName
     * @param string|null $billingLastName
     * @param string|null $billingFullName
     * @param string|null $billingCountry
     * @param string|null $billingState
     * @param string|null $billingCity
     * @param string|null $billingAddress
     * @param string|null $billingZip
     *
     * @return $this
     */
    public function addBillingData(
        $billingFirstName = null,
        $billingLastName = null,
        $billingFullName = null,
        $billingCountry = null,
        $billingState = null,
        $billingCity = null,
        $billingAddress = null,
        $billingZip = null
    ) {
        $this->assertOptionalString($billingFirstName, 'Billing first name must be string');
        $this->assertOptionalString($billingLastName, 'Billing last name must be string');
        $this->assertOptionalString($billingFullName, 'Billing full name must be string');
        $this->assertOptionalString($billingCountry, 'Billing country name must be string');
        $this->assertOptionalString($billingState, 'Billing state must be string');
        $this->assertOptionalString($billingCity, 'Billing city must be string');
        $this->assertOptionalString($billingAddress, 'Billing address must be string');
        $this->assertOptionalString($billingZip, 'Billing zip must be string');

        $this->replace('billing_firstname', $billingFirstName);
        $this->replace('billing_lastname', $billingLastName);
        $this->replace('billing_fullname', $billingFullName);
        $this->replace('billing_country', $billingCountry);
        $this->replace('billing_state', $billingState);
        $this->replace('billing_city', $billingCity);
        $this->replace('billing_address', $billingAddress);
        $this->replace('billing_zip', $billingZip);

        return $this;
    }
}
