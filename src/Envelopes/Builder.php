<?php

namespace Covery\Client\Envelopes;

use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

class Builder
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $sequenceId;
    /**
     * @var IdentityNodeInterface[]
     */
    private $identities = array();
    /**
     * @var array
     */
    private $data = array();

    /**
     * Returns builder for confirmation event
     *
     * @param string $sequenceId
     * @param string $userId
     * @param int|null $timestamp If null provided, takes current time
     * @param bool|null $isEmailConfirmed
     * @param bool|null $idPhoneConfirmed
     * @param string|null $email
     * @param string|null $phone
     *
     * @return Builder
     */
    public static function confirmationEvent(
        $sequenceId,
        $userId,
        $timestamp = null,
        $isEmailConfirmed = null,
        $idPhoneConfirmed = null,
        $email = null,
        $phone = null
    ) {
        $builder = new self('confirmation', $sequenceId);
        if ($timestamp === null) {
            $timestamp = time();
        }

        return $builder->addUserData(
            $email,
            $userId,
            $phone,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $timestamp,
            $isEmailConfirmed,
            $idPhoneConfirmed,
            null
        );
    }

    /**
     * Returns builder for login event
     *
     * @param string $sequenceId
     * @param string $userId
     * @param int|null $timestamp
     * @param string|null $email
     * @param bool|null $failed
     *
     * @return Builder
     */
    public static function loginEvent(
        $sequenceId,
        $userId,
        $timestamp = null,
        $email = null,
        $failed = null
    ) {
        $builder = new self('login', $sequenceId);
        if ($timestamp === null) {
            $timestamp = time();
        }

        return $builder->addUserData(
            $email,
            $userId,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $timestamp,
            null,
            null,
            null,
            $failed
        );
    }

    /**
     * Returns builder for registration event
     *
     * @param string $sequenceId
     * @param string $userId
     * @param int|null $timestamp
     * @param string|null $email
     * @param string|null $userName
     * @param string|null $firstName
     * @param string|null $lastName
     * @param int|null $age
     * @param string|null $gender
     * @param string|null $phone
     * @param string|null $country
     * @param string|null $socialType
     * @param string|null $websiteUrl
     * @param string|null $trafficSource
     * @param string|null $affiliateId
     *
     * @return Builder
     */
    public static function registrationEvent(
        $sequenceId,
        $userId,
        $timestamp = null,
        $email = null,
        $userName = null,
        $firstName = null,
        $lastName = null,
        $age = null,
        $gender = null,
        $phone = null,
        $country = null,
        $socialType = null,
        $websiteUrl = null,
        $trafficSource = null,
        $affiliateId = null
    ) {
        $builder = new self('registration', $sequenceId);
        if ($timestamp === null) {
            $timestamp = time();
        }

        return $builder->addWebsiteData(
            $websiteUrl,
            $trafficSource,
            $affiliateId
        )->addUserData(
            $email,
            $userId,
            $phone,
            $userName,
            $firstName,
            $lastName,
            $gender,
            $age,
            $country,
            $socialType,
            $timestamp,
            null,
            null,
            null,
            null,
            null
        );
    }

    /**
     * Returns builder for payout request
     *
     * @param string $sequenceId
     * @param string $userId
     * @param string $payoutId
     * @param string $cardId
     * @param string $currency
     * @param int|float $amount
     * @param int|float $amountConverted
     * @param int|null $payoutTimestamp
     * @param string|null $method
     * @param string|null $system
     * @param string|null $mid
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $country
     * @param string|null $email
     * @param string|null $phone
     * @param int|null $cardBin
     * @param string|null $cardLast4
     * @param int|null $cardExpirationMonth
     * @param int|null $cardExpirationYear
     *
     * @return Builder
     */
    public static function payoutEvent(
        $sequenceId,
        $userId,
        $payoutId,
        $cardId,
        $currency,
        $amount,
        $amountConverted,
        $payoutTimestamp = null,
        $method = null,
        $system = null,
        $mid = null,
        $firstName = null,
        $lastName = null,
        $country = null,
        $email = null,
        $phone = null,
        $cardBin = null,
        $cardLast4 = null,
        $cardExpirationMonth = null,
        $cardExpirationYear = null
    ) {
        $builder = new self('payout', $sequenceId);
        if ($payoutTimestamp === null) {
            $payoutTimestamp = time();
        }
        return $builder->addPayoutData(
            $payoutId,
            $payoutTimestamp,
            $cardId,
            $amount,
            $currency,
            $method,
            $system,
            $mid,
            $amountConverted,
            $cardBin,
            $cardLast4,
            $cardExpirationMonth,
            $cardExpirationYear
        )->addShortUserData($email, $userId, $phone, $firstName, $lastName, $country);
    }

    /**
     * Returns builder for transaction request
     *
     * @param string $sequenceId
     * @param string $userId
     * @param string $transactionId
     * @param int|float $transactionAmount
     * @param string $transactionCurrency
     * @param int|null $transactionTimestamp
     * @param string|null $transactionMode
     * @param string|null $transactionType
     * @param int|null $cardBin
     * @param string|null $cardId
     * @param string|null $cardLast4
     * @param int|null $expirationMonth
     * @param int|null $expirationYear
     * @param int|null $age
     * @param string|null $country
     * @param string|null $email
     * @param string|null $gender
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $phone
     * @param string|null $userName
     * @param string|null $paymentAccountId
     * @param string|null $paymentMethod
     * @param string|null $paymentMidName
     * @param string|null $paymentSystem
     * @param int|float|null $transactionAmountConverted
     * @param string|null $transactionSource
     * @param string|null $billingAddress
     * @param string|null $billingCity
     * @param string|null $billingCountry
     * @param string|null $billingFirstName
     * @param string|null $billingLastName
     * @param string|null $billingFullName
     * @param string|null $billingState
     * @param string|null $billingZip
     * @param string|null $productDescription
     * @param string|null $productName
     * @param int|float|null $productQuantity
     * @param string|null $websiteUrl
     * @param string|null $merchantIp
     *
     * @return Builder
     */
    public static function transactionEvent(
        $sequenceId,
        $userId,
        $transactionId,
        $transactionAmount,
        $transactionCurrency,
        $transactionTimestamp = null,
        $transactionMode = null,
        $transactionType = null,
        $cardBin = null,
        $cardId = null,
        $cardLast4 = null,
        $expirationMonth = null,
        $expirationYear = null,
        $age = null,
        $country = null,
        $email = null,
        $gender = null,
        $firstName = null,
        $lastName = null,
        $phone = null,
        $userName = null,
        $paymentAccountId = null,
        $paymentMethod = null,
        $paymentMidName = null,
        $paymentSystem = null,
        $transactionAmountConverted = null,
        $transactionSource = null,
        $billingAddress = null,
        $billingCity = null,
        $billingCountry = null,
        $billingFirstName = null,
        $billingLastName = null,
        $billingFullName = null,
        $billingState = null,
        $billingZip = null,
        $productDescription = null,
        $productName = null,
        $productQuantity = null,
        $websiteUrl = null,
        $merchantIp = null
    ) {
        $builder = new self('transaction', $sequenceId);
        if ($transactionTimestamp === null) {
            $transactionTimestamp = time();
        }

        return $builder
            ->addCCTransactionData(
                $transactionId,
                $transactionSource,
                $transactionType,
                $transactionMode,
                $transactionTimestamp,
                $transactionCurrency,
                $transactionAmount,
                $transactionAmountConverted,
                $paymentMethod,
                $paymentSystem,
                $paymentMidName,
                $paymentAccountId
            )
            ->addBillingData(
                $billingFirstName,
                $billingLastName,
                $billingFullName,
                $billingCountry,
                $billingState,
                $billingCity,
                $billingAddress,
                $billingZip
            )
            ->addCardData($cardBin, $cardLast4, $expirationMonth, $expirationYear, $cardId)
            ->addUserData(
                $email,
                $userId,
                $phone,
                $userName,
                $firstName,
                $lastName,
                $gender,
                $age,
                $country
            )
            ->addProductData($productQuantity, $productName, $productDescription)
            ->addWebsiteData($websiteUrl)
            ->addIpData(null, null, $merchantIp);

    }

    /**
     * Returns builder for install request
     *
     * @param string $sequenceId
     * @param string|null $userId
     * @param int|null $installTimestamp
     * @param string|null $country
     * @param string|null $websiteUrl
     * @param string|null $trafficSource
     * @param string|null $affiliateId
     *
     * @return Builder
     */
    public static function installEvent(
        $sequenceId,
        $userId = null,
        $installTimestamp = null,
        $country = null,
        $websiteUrl = null,
        $trafficSource = null,
        $affiliateId = null
    ) {
        $builder = new self('install', $sequenceId);
        if ($installTimestamp === null) {
            $installTimestamp = time();
        }

        return $builder->addInstallData(
            $installTimestamp
        )->addWebsiteData($websiteUrl, $trafficSource, $affiliateId)
        ->addShortUserData(null, $userId, null, null, null, $country);
    }

    /**
     * Returns builder for refund request
     *
     * @param string $sequenceId
     * @param string $refundId
     * @param int|float $refundAmount
     * @param string $refundCurrency
     * @param int|null $refundTimestamp
     * @param int|float|null $refundAmountConverted
     * @param string|null $refundSource
     * @param string|null $refundType
     * @param string|null $refundCode
     * @param string|null $refundReason
     * @param string|null $agentId
     *
     * @return Builder
     */
    public static function refundEvent(
        $sequenceId,
        $refundId,
        $refundAmount,
        $refundCurrency,
        $refundTimestamp = null,
        $refundAmountConverted = null,
        $refundSource = null,
        $refundType = null,
        $refundCode = null,
        $refundReason = null,
        $agentId = null
    ) {
        $builder = new self('refund', $sequenceId);
        if ($refundTimestamp === null) {
            $refundTimestamp = time();
        }

        return $builder->addRefundData(
            $refundId,
            $refundTimestamp,
            $refundAmount,
            $refundCurrency,
            $refundAmountConverted,
            $refundSource,
            $refundType,
            $refundCode,
            $refundReason,
            $agentId
        );
    }

    /**
     * Builder constructor.
     *
     * @param string $envelopeType
     * @param string $sequenceId
     */
    public function __construct($envelopeType, $sequenceId)
    {
        if (!is_string($envelopeType)) {
            throw new \InvalidArgumentException('Envelope type must be string');
        }
        if (!is_string($sequenceId)) {
            throw new \InvalidArgumentException('Sequence ID must be string');
        }

        $this->type = $envelopeType;
        $this->sequenceId = $sequenceId;
    }

    /**
     * Returns built envelope
     *
     * @return EnvelopeInterface
     */
    public function build()
    {
        return new Envelope(
            $this->type,
            $this->sequenceId,
            $this->identities,
            array_filter($this->data, function ($data) {
                return $data !== null;
            })
        );
    }

    /**
     * Replaces value in internal array if provided value not empty
     *
     * @param string $key
     * @param string|int|float|bool|null $value
     */
    private function replace($key, $value)
    {
        if ($value !== null && $value !== '' && $value !== 0 && $value !== 0.0) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Adds identity node
     *
     * @param IdentityNodeInterface $identity
     *
     * @return $this
     */
    public function addIdentity(IdentityNodeInterface $identity)
    {
        $this->identities[] = $identity;
        return $this;
    }

    /**
     * Provides website URL to envelope
     *
     * @param string|null $websiteUrl
     * @param string|null $traffic_source
     * @param string|null $affiliate_id
     *
     * @return $this
     */
    public function addWebsiteData($websiteUrl = null, $traffic_source = null, $affiliate_id = null)
    {
        if ($websiteUrl !== null && !is_string($websiteUrl)) {
            throw new \InvalidArgumentException('Website URL must be string');
        }
        if ($traffic_source !== null && !is_string($traffic_source)) {
            throw new \InvalidArgumentException('Traffic source must be string');
        }
        if ($affiliate_id !== null && !is_string($affiliate_id)) {
            throw new \InvalidArgumentException('Affiliate ID must be string');
        }

        $this->replace('website_url', $websiteUrl);
        $this->replace('traffic_source', $traffic_source);
        $this->replace('affiliate_id', $affiliate_id);
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
        if ($ip !== null && !is_string($ip)) {
            throw new \InvalidArgumentException('IP must be string');
        }
        if ($realIp !== null && !is_string($realIp)) {
            throw new \InvalidArgumentException('Real IP must be string');
        }
        if ($merchantIp !== null && !is_string($merchantIp)) {
            throw new \InvalidArgumentException('Merchant IP must be string');
        }

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
     *
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
        $ajaxValidation = null
    ) {
        if ($deviceFingerprint !== null && !is_string($deviceFingerprint)) {
            throw new \InvalidArgumentException('Device fingerprint must be string');
        }
        if ($userAgent !== null && !is_string($userAgent)) {
            throw new \InvalidArgumentException('User agent must be string');
        }
        if ($cpuClass !== null && !is_string($cpuClass)) {
            throw new \InvalidArgumentException('CPU class must be string');
        }
        if ($screenOrientation !== null && !is_string($screenOrientation)) {
            throw new \InvalidArgumentException('Screen orientation must be string');
        }
        if ($screenResolution !== null && !is_string($screenResolution)) {
            throw new \InvalidArgumentException('Screen resolution must be string');
        }
        if ($os !== null && !is_string($os)) {
            throw new \InvalidArgumentException('OS must be string');
        }
        if ($timezoneOffset !== null && $timezoneOffset !== null && !is_int($timezoneOffset)) {
            throw new \InvalidArgumentException('Timezone offset must be integer or null');
        }
        if ($languages !== null && !is_string($languages)) {
            throw new \InvalidArgumentException('Languages must be string');
        }
        if ($language !== null && !is_string($language)) {
            throw new \InvalidArgumentException('Language must be string');
        }
        if ($languageBrowser !== null && !is_string($languageBrowser)) {
            throw new \InvalidArgumentException('Browser language must be string');
        }
        if ($languageUser !== null && !is_string($languageUser)) {
            throw new \InvalidArgumentException('User language must be string');
        }
        if ($languageSystem !== null && !is_string($languageSystem)) {
            throw new \InvalidArgumentException('System language must be string');
        }
        if ($cookieEnabled !== null && !is_bool($cookieEnabled)) {
            throw new \InvalidArgumentException('Cookie enabled flag must be boolean');
        }
        if ($doNotTrack !== null && !is_bool($doNotTrack)) {
            throw new \InvalidArgumentException('DNT flag must be boolean');
        }
        if ($ajaxValidation !== null && !is_bool($ajaxValidation)) {
            throw new \InvalidArgumentException('AJAX validation flag must be boolean');
        }

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
        $this->replace('ajax_validation', $ajaxValidation);

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
        $loginFailed = null
    ) {
        if ($userName !== null && !is_string($userName)) {
            throw new \InvalidArgumentException('User name must be string');
        }
        if ($gender !== null && !is_string($gender)) {
            throw new \InvalidArgumentException('Gender must be string');
        }
        if ($age !== null && !is_int($age)) {
            throw new \InvalidArgumentException('Age must be integer');
        }
        if ($socialType !== null && !is_string($socialType)) {
            throw new \InvalidArgumentException('Social type must be string');
        }
        if ($registrationTimestamp !== null && !is_int($registrationTimestamp)) {
            throw new \InvalidArgumentException('Registration timestamp must be integer');
        }
        if ($loginTimeStamp !== null && !is_int($loginTimeStamp)) {
            throw new \InvalidArgumentException('Login timestamp must be integer');
        }
        if ($confirmationTimeStamp !== null && !is_int($confirmationTimeStamp)) {
            throw new \InvalidArgumentException('Confirmation timestamp must be integer');
        }
        if ($emailConfirmed !== null && !is_bool($emailConfirmed)) {
            throw new \InvalidArgumentException('Email confirmed flag must be boolean');
        }
        if ($phoneConfirmed !== null && !is_bool($phoneConfirmed)) {
            throw new \InvalidArgumentException('Phone confirmed flag must be boolean');
        }
        if ($loginFailed !== null && !is_bool($loginFailed)) {
            throw new \InvalidArgumentException('Login failed flag must be boolean');
        }

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
        if ($email !== null && !is_string($email)) {
            throw new \InvalidArgumentException('Email must be string');
        }
        if (is_int($userId)) {
            $userId = strval($userId);
        }
        if ($userId !== null && !is_string($userId)) {
            throw new \InvalidArgumentException('UserId must be string or integer');
        }
        if ($phone !== null && !is_string($phone)) {
            throw new \InvalidArgumentException('Phone must be string');
        }
        if ($firstName !== null && !is_string($firstName)) {
            throw new \InvalidArgumentException('First name must be string');
        }
        if ($lastName !== null && !is_string($lastName)) {
            throw new \InvalidArgumentException('Last name must be string');
        }
        if ($country !== null && !is_string($country)) {
            throw new \InvalidArgumentException('Country must be string');
        }

        $this->replace('email', $email);
        $this->replace('user_merchant_id', $userId);
        $this->replace('phone', $phone);
        $this->replace('firstname', $firstName);
        $this->replace('lastname', $lastName);
        $this->replace('country', $country);

        return $this;
    }

    /**
     * Provides credit card data to envelope
     *
     * @param string|null $transactionId
     * @param string|null $transactionSource
     * @param string|null $transactionType
     * @param string|null $transactionMode
     * @param string|null $transactionTimestamp
     * @param string|null $transactionCurrency
     * @param string|null $transactionAmount
     * @param float|null $amountConverted
     * @param string|null $paymentMethod
     * @param string|null $paymentSystem
     * @param string|null $paymentMidName
     * @param string|null $paymentAccountId
     *
     * @return $this
     */
    public function addCCTransactionData(
        $transactionId,
        $transactionSource,
        $transactionType,
        $transactionMode,
        $transactionTimestamp,
        $transactionCurrency,
        $transactionAmount,
        $amountConverted = null,
        $paymentMethod = null,
        $paymentSystem = null,
        $paymentMidName = null,
        $paymentAccountId = null
    ) {
        if ($transactionId !== null && !is_string($transactionId)) {
            throw new \InvalidArgumentException('Transaction ID must be string');
        }
        if ($transactionSource !== null && !is_string($transactionSource)) {
            throw new \InvalidArgumentException('Transaction source must be string');
        }
        if ($transactionType !== null && !is_string($transactionType)) {
            throw new \InvalidArgumentException('Transaction type must be string');
        }
        if ($transactionMode !== null && !is_string($transactionMode)) {
            throw new \InvalidArgumentException('Transaction mode must be string');
        }
        if ($transactionTimestamp !== null && !is_int($transactionTimestamp)) {
            throw new \InvalidArgumentException('Transaction timestamp must be integer');
        }
        if ($transactionAmount !== null && !is_int($transactionAmount) && !is_float($transactionAmount)) {
            throw new \InvalidArgumentException('Transaction amount must be float');
        }
        if ($transactionCurrency !== null && !is_string($transactionCurrency)) {
            throw new \InvalidArgumentException('Transaction currency must be string');
        }
        if ($paymentMethod !== null && !is_string($paymentMethod)) {
            throw new \InvalidArgumentException('Payment method must be string');
        }
        if ($paymentSystem !== null && !is_string($paymentSystem)) {
            throw new \InvalidArgumentException('Payment system must be string');
        }
        if ($paymentMidName !== null && !is_string($paymentMidName)) {
            throw new \InvalidArgumentException('Payment MID name must be string');
        }
        if ($paymentAccountId !== null && !is_string($paymentAccountId)) {
            throw new \InvalidArgumentException('Payment account id must be string');
        }
        if ($amountConverted !== null && !is_int($amountConverted) && !is_float($amountConverted)) {
            throw new \InvalidArgumentException('Transaction amount converted must be float');
        }

        $this->replace('transaction_id', $transactionId);
        $this->replace('transaction_source', $transactionSource);
        $this->replace('transaction_type', $transactionType);
        $this->replace('transaction_mode', $transactionMode);
        $this->replace('transaction_timestamp', $transactionTimestamp);
        $this->replace('transaction_amount', floatval($transactionAmount));
        $this->replace('transaction_amount_converted', floatval($amountConverted));
        $this->replace('transaction_currency', $transactionCurrency);
        $this->replace('payment_method', $paymentMethod);
        $this->replace('payment_system', $paymentSystem);
        $this->replace('payment_mid', $paymentMidName);
        $this->replace('payment_account_id', $paymentAccountId);

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
        if ($cardId !== null && !is_string($cardId)) {
            throw new \InvalidArgumentException('Card ID must be string');
        }
        if ($cardBin !== null && !is_int($cardBin)) {
            throw new \InvalidArgumentException('Card BIN must be integer');
        }
        if ($cardLast4 !== null && !is_string($cardLast4)) {
            throw new \InvalidArgumentException('Card last4  must be string');
        }
        if ($expirationMonth !== null && !is_int($expirationMonth)) {
            throw new \InvalidArgumentException('Expiration month must be integer');
        }
        if ($expirationYear !== null && !is_int($expirationYear)) {
            throw new \InvalidArgumentException('Expiration year must be integer');
        }

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
        if ($billingFirstName !== null && !is_string($billingFirstName)) {
            throw new \InvalidArgumentException('Billing first name must be string');
        }
        if ($billingLastName !== null && !is_string($billingLastName)) {
            throw new \InvalidArgumentException('Billing last name must be string');
        }
        if ($billingFullName !== null && !is_string($billingFullName)) {
            throw new \InvalidArgumentException('Billing full name must be string');
        }
        if ($billingCountry !== null && !is_string($billingCountry)) {
            throw new \InvalidArgumentException('Billing country name must be string');
        }
        if ($billingState !== null && !is_string($billingState)) {
            throw new \InvalidArgumentException('Billing state must be string');
        }
        if ($billingCity !== null && !is_string($billingCity)) {
            throw new \InvalidArgumentException('Billing city must be string');
        }
        if ($billingAddress !== null && !is_string($billingAddress)) {
            throw new \InvalidArgumentException('Billing address must be string');
        }
        if ($billingZip !== null && !is_string($billingZip)) {
            throw new \InvalidArgumentException('Billing zip must be string');
        }

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

    /**
     * Provides product information to envelope
     *
     * @param float|null $productQuantity
     * @param string|null $productName
     * @param string|null $productDescription
     *
     * @return $this
     */
    public function addProductData(
        $productQuantity = null,
        $productName = null,
        $productDescription = null
    ) {
        if ($productQuantity !== null && !is_int($productQuantity) && !is_float($productQuantity)) {
            throw new \InvalidArgumentException('Product quantity must be int or float');
        }
        if ($productName !== null && !is_string($productName)) {
            throw new \InvalidArgumentException('Product name must be string');
        }
        if ($productDescription !== null && !is_string($productDescription)) {
            throw new \InvalidArgumentException('Product description must be string');
        }

        $this->replace('product_quantity', $productQuantity);
        $this->replace('product_name', $productName);
        $this->replace('product_description', $productDescription);

        return $this;
    }

    /**
     * Provides payout information to envelope
     *
     * @param string $payoutId
     * @param int $payoutTimestamp
     * @param string $payoutCardId
     * @param int|float $payoutAmount
     * @param string $payoutCurrency
     * @param string|null $payoutMethod
     * @param string|null $payoutSystem
     * @param string|null $payoutMid
     * @param int|float|null $amountConverted
     * @param int|null $payoutCardBin
     * @param string|null $payoutCardLast4
     * @param int|null $payoutExpirationMonth
     * @param int|null $payoutExpirationYear
     *
     * @return $this
     */
    public function addPayoutData(
        $payoutId,
        $payoutTimestamp,
        $payoutCardId,
        $payoutAmount,
        $payoutCurrency,
        $payoutMethod = null,
        $payoutSystem = null,
        $payoutMid = null,
        $amountConverted = null,
        $payoutCardBin = null,
        $payoutCardLast4 = null,
        $payoutExpirationMonth = null,
        $payoutExpirationYear = null
    ) {
        if (!is_string($payoutId)) {
            throw new \InvalidArgumentException('Payout ID must be string');
        }
        if (!is_int($payoutTimestamp)) {
            throw new \InvalidArgumentException('Payout timestamp must be int');
        }
        if (!is_string($payoutCardId)) {
            throw new \InvalidArgumentException('Card ID must be string');
        }
        if (!is_float($payoutAmount) && !is_int($payoutAmount)) {
            throw new \InvalidArgumentException('Amount must be number');
        }
        if (!is_string($payoutCurrency)) {
            throw new \InvalidArgumentException('Payout currency must be string');
        }
        if ($payoutMethod !== null && !is_string($payoutMethod)) {
            throw new \InvalidArgumentException('Payout method must be string');
        }
        if ($payoutSystem !== null && !is_string($payoutSystem)) {
            throw new \InvalidArgumentException('Payout system must be string');
        }
        if ($payoutMid !== null && !is_string($payoutMid)) {
            throw new \InvalidArgumentException('Payout MID must be string');
        }
        if ($amountConverted !== null && !is_float($amountConverted) && !is_int($amountConverted)) {
            throw new \InvalidArgumentException('Payout converted amount must be number');
        }
        if ($payoutCardBin !== null && !is_int($payoutCardBin)) {
            throw new \InvalidArgumentException('Payout card BIN must be integer');
        }
        if ($payoutCardLast4 !== null && !is_string($payoutCardLast4)) {
            throw new \InvalidArgumentException('Payout last 4 must be string');
        }
        if ($payoutExpirationMonth !== null && !is_int($payoutExpirationMonth)) {
            throw new \InvalidArgumentException('Payout card expiration month must be integer');
        }
        if ($payoutExpirationYear !== null && !is_int($payoutExpirationYear)) {
            throw new \InvalidArgumentException('Payout card expiration year must be integer');
        }

        $this->replace('payout_id', $payoutId);
        $this->replace('payout_timestamp', $payoutTimestamp);
        $this->replace('payout_card_id', $payoutCardId);
        $this->replace('payout_amount', (float) $payoutAmount);
        $this->replace('payout_currency', $payoutCurrency);
        $this->replace('payout_method', $payoutMethod);
        $this->replace('payout_system', $payoutSystem);
        $this->replace('payout_mid', $payoutMid);
        $this->replace('payout_amount_converted', (float) $amountConverted);
        $this->replace('payout_card_bin', $payoutCardBin);
        $this->replace('payout_card_last4', $payoutCardLast4);
        $this->replace('payout_expiration_month', $payoutExpirationMonth);
        $this->replace('payout_expiration_year', $payoutExpirationYear);

        return $this;
    }

    /**
     * Provides install information to envelope
     *
     * @param int $installTimestamp
     *
     * @return $this
     */
    public function addInstallData($installTimestamp)
    {
        if (!is_int($installTimestamp)) {
            throw new \InvalidArgumentException('Install timestamp must be int');
        }

        $this->replace('install_timestamp', $installTimestamp);

        return $this;
    }

    /**
     * Provides refund information to envelope
     *
     * @param string $refundId
     * @param int|float $refundAmount
     * @param string $refundCurrency
     * @param int|null $refundTimestamp
     * @param int|float|null $refundAmountConverted
     * @param string|null $refundSource
     * @param string|null $refundType
     * @param string|null $refundCode
     * @param string|null $refundReason
     * @param string|null $agentId
     *
     * @return $this
     */
    public function addRefundData(
        $refundId,
        $refundTimestamp,
        $refundAmount,
        $refundCurrency,
        $refundAmountConverted = null,
        $refundSource = null,
        $refundType = null,
        $refundCode = null,
        $refundReason = null,
        $agentId = null
    ) {
        if (!is_string($refundId)) {
            throw new \InvalidArgumentException('Refund ID must be string');
        }
        if (!is_int($refundTimestamp)) {
            throw new \InvalidArgumentException('Refund timestamp must be int');
        }
        if (!is_float($refundAmount) && !is_int($refundAmount)) {
            throw new \InvalidArgumentException('Amount must be number');
        }
        if (!is_string($refundCurrency)) {
            throw new \InvalidArgumentException('Refund currency must be string');
        }
        if ($refundAmountConverted !== null && !is_float($refundAmountConverted) && !is_int($refundAmountConverted)) {
            throw new \InvalidArgumentException('Refund converted amount must be number');
        }
        if ($refundSource !== null && !is_string($refundSource)) {
            throw new \InvalidArgumentException('Refund source must be string');
        }
        if ($refundType !== null && !is_string($refundType)) {
            throw new \InvalidArgumentException('Refund type must be string');
        }
        if ($refundCode !== null && !is_string($refundCode)) {
            throw new \InvalidArgumentException('Refund code must be string');
        }
        if ($refundReason !== null && !is_string($refundReason)) {
            throw new \InvalidArgumentException('Refund reason must be string');
        }
        if ($agentId !== null && !is_string($agentId)) {
            throw new \InvalidArgumentException('Agent id must be string');
        }

        $this->replace('refund_id', $refundId);
        $this->replace('refund_timestamp', $refundTimestamp);
        $this->replace('refund_amount', $refundAmount);
        $this->replace('refund_currency', $refundCurrency);
        $this->replace('refund_amount_converted', $refundAmountConverted);
        $this->replace('refund_source', $refundSource);
        $this->replace('refund_type', $refundType);
        $this->replace('refund_code', $refundCode);
        $this->replace('refund_reason', $refundReason);
        $this->replace('agent_id', $agentId);

        return $this;
    }

    /**
     * Adds custom data field to envelope
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addCustomField($name, $value)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('Custom field name must be string');
        }
        if (!is_string($value)) {
            throw new \InvalidArgumentException('Custom field value must be string');
        }

        if (strlen($name) < 8 || substr($name, 0, 7) !== 'custom_') {
            $name = 'custom_' . $name;
        }

        $this->replace($name, $value);
        return $this;
    }
}
