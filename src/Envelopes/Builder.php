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
     * @param string|null $groupId
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
        $phone = null,
        $groupId = null
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
        )->addGroupId($groupId);
    }

    /**
     * Returns builder for login event
     *
     * @param string $sequenceId
     * @param string $userId
     * @param int|null $timestamp
     * @param string|null $email
     * @param bool|null $failed
     * @param string|null $gender
     * @param string|null $trafficSource
     * @param string|null $affiliateId
     * @param string|null $password
     * @param string|null $campaign
     * @param string|null $groupId
     *
     * @return Builder
     */
    public static function loginEvent(
        $sequenceId,
        $userId,
        $timestamp = null,
        $email = null,
        $failed = null,
        $gender = null,
        $trafficSource = null,
        $affiliateId = null,
        $password = null,
        $campaign = null,
        $groupId = null
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
            $gender,
            null,
            null,
            null,
            null,
            $timestamp,
            null,
            null,
            null,
            $failed,
            null,
            null,
            null,
            null,
            null,
            null,
            $password
        )->addWebsiteData(null, $trafficSource, $affiliateId, $campaign)->addGroupId($groupId);
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
     * @param string|null $password
     * @param string|null $campaign
     * @param string|null $groupId
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
        $affiliateId = null,
        $password = null,
        $campaign = null,
        $groupId = null
    ) {
        $builder = new self('registration', $sequenceId);
        if ($timestamp === null) {
            $timestamp = time();
        }

        return $builder->addWebsiteData(
            $websiteUrl,
            $trafficSource,
            $affiliateId,
            $campaign
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
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $password
        )-> addGroupId($groupId);
    }

    /**
     * Returns builder for payout request
     *
     * @param string $sequenceId
     * @param string $userId
     * @param string $payoutId
     * @param string $currency
     * @param int|float $amount
     * @param int|null $payoutTimestamp
     * @param string|null $cardId
     * @param string|null $accountId
     * @param string|null $method
     * @param string|null $system
     * @param string|null $mid
     * @param int|float $amountConverted
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $country
     * @param string|null $email
     * @param string|null $phone
     * @param int|null $cardBin
     * @param string|null $cardLast4
     * @param int|null $cardExpirationMonth
     * @param int|null $cardExpirationYear
     * @param string|null $groupId
     *
     * @return Builder
     */
    public static function payoutEvent(
        $sequenceId,
        $userId,
        $payoutId,
        $currency,
        $amount,
        $payoutTimestamp = null,
        $cardId = null,
        $accountId = null,
        $method = null,
        $system = null,
        $mid = null,
        $amountConverted = null,
        $firstName = null,
        $lastName = null,
        $country = null,
        $email = null,
        $phone = null,
        $cardBin = null,
        $cardLast4 = null,
        $cardExpirationMonth = null,
        $cardExpirationYear = null,
        $groupId = null
    ) {
        $builder = new self('payout', $sequenceId);
        if ($payoutTimestamp === null) {
            $payoutTimestamp = time();
        }
        return $builder->addPayoutData(
            $payoutId,
            $payoutTimestamp,
            $amount,
            $currency,
            $cardId,
            $accountId,
            $method,
            $system,
            $mid,
            $amountConverted,
            $cardBin,
            $cardLast4,
            $cardExpirationMonth,
            $cardExpirationYear
        )->addShortUserData($email, $userId, $phone, $firstName, $lastName, $country)->addGroupId($groupId);
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
     * @param string|null $affiliateId
     * @param string|null $campaign
     * @param string|null $merchantCountry
     * @param string|null $mcc
     * @param string|null $acquirerMerchantId
     * @param string|null $groupId
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
        $merchantIp = null,
        $affiliateId = null,
        $campaign = null,
        $merchantCountry = null,
        $mcc = null,
        $acquirerMerchantId = null,
        $groupId = null
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
                $paymentAccountId,
                $merchantCountry,
                $mcc,
                $acquirerMerchantId
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
            ->addWebsiteData($websiteUrl, null, $affiliateId, $campaign)
            ->addIpData(null, null, $merchantIp)
            ->addGroupId($groupId);

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
     * @param string|null $campaign
     * @param string|null $groupId
     * @return Builder
     */
    public static function installEvent(
        $sequenceId,
        $userId = null,
        $installTimestamp = null,
        $country = null,
        $websiteUrl = null,
        $trafficSource = null,
        $affiliateId = null,
        $campaign = null,
        $groupId = null
    ) {
        $builder = new self('install', $sequenceId);
        if ($installTimestamp === null) {
            $installTimestamp = time();
        }

        return $builder->addInstallData(
            $installTimestamp
        )->addWebsiteData($websiteUrl, $trafficSource, $affiliateId, $campaign)
        ->addShortUserData(null, $userId, null, null, null, $country)
        ->addGroupId($groupId);
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
     * @param string|null $refundMethod
     * @param string|null $refundSystem
     * @param string|null $refundMid
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $userId
     * @param string|null $groupId
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
        $agentId = null,
        $refundMethod = null,
        $refundSystem = null,
        $refundMid = null,
        $email = null,
        $phone = null,
        $userId = null,
        $groupId = null
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
            $agentId,
            $refundMethod,
            $refundSystem,
            $refundMid
        )->addUserData($email, $userId, $phone)->addGroupId($groupId);
    }

    /**
     * Returns builder for transfer request
     *
     * @param string $sequenceId
     * @param string $eventId
     * @param float $amount
     * @param string $currency
     * @param string $userId
     * @param string $accountId
     * @param string $secondAccountId
     * @param string $accountSystem
     * @param string|null $method
     * @param int|null $eventTimestamp
     * @param float|null $amountConverted
     * @param string|null $email
     * @param string|null $phone
     * @param int|null $birthDate
     * @param string|null $firstname
     * @param string|null $lastname
     * @param string|null $fullname
     * @param string|null $state
     * @param string|null $city
     * @param string|null $address
     * @param string|null $zip
     * @param string|null $gender
     * @param string|null $country
     * @param string|null $operation
     * @param string|null $secondEmail
     * @param string|null $secondPhone
     * @param int|null $secondBirthDate
     * @param string|null $secondFirstname
     * @param string|null $secondLastname
     * @param string|null $secondFullname
     * @param string|null $secondState
     * @param string|null $secondCity
     * @param string|null $secondAddress
     * @param string|null $secondZip
     * @param string|null $secondGender
     * @param string|null $secondCountry
     * @param string|null $productDescription
     * @param string|null $productName
     * @param int|float|null $productQuantity
     * @param string|null $iban
     * @param string|null $secondIban
     * @param string|null $bic
     * @param string|null $source
     * @param string|null $groupId
     * @param string|null $secondUserMerchantId
     *
     * @return Builder
     */
    public static function transferEvent(
        $sequenceId,
        $eventId,
        $amount,
        $currency,
        $userId,
        $accountId = null,
        $secondAccountId = null,
        $accountSystem = null,
        $method = null,
        $eventTimestamp = null,
        $amountConverted = null,
        $email = null,
        $phone = null,
        $birthDate = null,
        $firstname = null,
        $lastname = null,
        $fullname = null,
        $state = null,
        $city = null,
        $address = null,
        $zip = null,
        $gender = null,
        $country = null,
        $operation = null,
        $secondEmail = null,
        $secondPhone = null,
        $secondBirthDate = null,
        $secondFirstname = null,
        $secondLastname = null,
        $secondFullname = null,
        $secondState = null,
        $secondCity = null,
        $secondAddress = null,
        $secondZip = null,
        $secondGender = null,
        $secondCountry = null,
        $productDescription = null,
        $productName = null,
        $productQuantity = null,
        $iban = null,
        $secondIban = null,
        $bic = null,
        $source = null,
        $groupId = null,
        $secondUserMerchantId = null
    ) {
        $builder = new self('transfer', $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }

        return $builder
            ->addTransferData(
               $eventId,
               $eventTimestamp,
               $amount,
               $currency,
               $accountId,
               $secondAccountId,
               $accountSystem,
               $amountConverted,
               $method,
               $operation,
               $secondEmail,
               $secondPhone,
               $secondBirthDate,
               $secondFirstname,
               $secondLastname,
               $secondFullname,
               $secondState,
               $secondCity,
               $secondAddress,
               $secondZip,
               $secondGender,
               $secondCountry,
               $iban,
               $secondIban,
               $bic,
               $source,
               $secondUserMerchantId
            )
            ->addUserData(
                $email,
                $userId,
                $phone,
                null,
                $firstname,
                $lastname,
                $gender,
                null,
                $country,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $birthDate,
                $fullname,
                $state,
                $city,
                $address,
                $zip,
                null
            )
            ->addProductData($productQuantity, $productName, $productDescription)->addGroupId($groupId);
    }

    /**
     * Returns builder for kyc_profile request
     *
     * @param string $sequenceId
     * @param string $eventId
     * @param string $userId
     * @param int|null $eventTimestamp
     * @param string|null $groupId
     * @param string|null $status
     * @param string|null $code
     * @param string|null $reason
     * @param string|null $providerResult
     * @param string|null $providerCode
     * @param string|null $providerReason
     * @param string|null $profileId
     * @param string|null $profileType
     * @param string|null $profileSubType
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $fullName
     * @param string|null $industry
     * @param string|null $websiteUrl
     * @param string|null $description
     * @param int|null $birthDate
     * @param int|null $regDate
     * @param string|null $regNumber
     * @param string|null $vatNumber
     * @param string|null $email
     * @param bool|null $emailConfirmed
     * @param string|null $phone
     * @param bool|null $phoneConfirmed
     * @param string|null $country
     * @param string|null $state
     * @param string|null $city
     * @param string|null $address
     * @param string|null $zip
     * @param string|null $secondCountry
     * @param string|null $secondState
     * @param string|null $secondCity
     * @param string|null $secondAddress
     * @param string|null $secondZip
     * @param string|null $providerId
     * @param string|null $contactEmail
     * @param string|null $contactPhone
     * @param string|null $walletType
     * @param string|null $nationality
     * @param bool|null $finalBeneficiary
     * @param string|null $employmentStatus
     * @param string|null $sourceOfFunds
     * @param int|null $issueDate
     * @param int|null $expiryDate
     * @param string|null $gender
     * @return Builder
     */
    public static function kycProfileEvent(
        $sequenceId,
        $eventId,
        $userId,
        $eventTimestamp = null,
        $groupId = null,
        $status = null,
        $code = null,
        $reason = null,
        $providerResult = null,
        $providerCode = null,
        $providerReason = null,
        $profileId = null,
        $profileType = null,
        $profileSubType = null,
        $firstName = null,
        $lastName = null,
        $fullName = null,
        $industry = null,
        $websiteUrl = null,
        $description = null,
        $birthDate = null,
        $regDate = null,
        $regNumber = null,
        $vatNumber = null,
        $email = null,
        $emailConfirmed = null,
        $phone = null,
        $phoneConfirmed = null,
        $country = null,
        $state = null,
        $city = null,
        $address = null,
        $zip = null,
        $secondCountry = null,
        $secondState = null,
        $secondCity = null,
        $secondAddress = null,
        $secondZip = null,
        $providerId = null,
        $contactEmail = null,
        $contactPhone = null,
        $walletType = null,
        $nationality = null,
        $finalBeneficiary = null,
        $employmentStatus = null,
        $sourceOfFunds = null,
        $issueDate = null,
        $expiryDate = null,
        $gender = null
    ) {
        $builder = new self('kyc_profile', $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }
        return $builder
            ->addKycData(
                $eventId,
                $eventTimestamp,
                $groupId,
                $status,
                $code,
                $reason,
                $providerResult,
                $providerCode,
                $providerReason,
                $profileId,
                $profileType,
                $profileSubType,
                $industry,
                $description,
                $regDate,
                $regNumber,
                $vatNumber,
                $secondCountry,
                $secondState,
                $secondCity,
                $secondAddress,
                $secondZip,
                $providerId,
                $contactEmail,
                $contactPhone,
                $walletType,
                $nationality,
                $finalBeneficiary,
                $employmentStatus,
                $sourceOfFunds,
                $issueDate,
                $expiryDate
            )
            ->addUserData(
                $email,
                $userId,
                $phone,
                null,
                $firstName,
                $lastName,
                $gender,
                null,
                $country,
                null,
                null,
                null,
                null,
                $emailConfirmed,
                $phoneConfirmed,
                null,
                $birthDate,
                $fullName,
                $state,
                $city,
                $address,
                $zip,
                null
            )
            ->addWebsiteData($websiteUrl);
    }

    /**
     * Returns builder for kyc_submit request
     *
     * @param string $sequenceId
     * @param string $eventId
     * @param string $userId
     * @param int|null $eventTimestamp
     * @param string|null $groupId
     * @param string|null $status
     * @param string|null $code
     * @param string|null $reason
     * @param string|null $providerResult
     * @param string|null $providerCode
     * @param string|null $providerReason
     *
     * @return Builder
     */
    public static function kycSubmitEvent(
        $sequenceId,
        $eventId,
        $userId,
        $eventTimestamp = null,
        $groupId = null,
        $status = null,
        $code = null,
        $reason = null,
        $providerResult = null,
        $providerCode = null,
        $providerReason = null
    ) {
        $builder = new self('kyc_submit', $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }
        return $builder
            ->addKycData(
                $eventId,
                $eventTimestamp,
                $groupId,
                $status,
                $code,
                $reason,
                $providerResult,
                $providerCode,
                $providerReason
            )
            ->addUserData(
                null,
                $userId
            );
    }

    /**
     * Returns builder for kyc_start request
     *
     * @param string $sequenceId
     * @param string $eventId
     * @param string $userMerchantId
     * @param string $verificationMode
     * @param string $verificationSource
     * @param bool $consent
     * @param null|int $eventTimestamp
     * @param bool|null $allowNaOcrInputs
     * @param bool|null $declineOnSingleStep
     * @param bool|null $backsideProof
     * @param string|null $groupId
     * @param string|null $country
     * @param string|null $kycLanguage
     * @param string|null $redirectUrl
     * @param string|null $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $profileId
     * @param string|null $phone
     * @param string|null $birthDate
     * @param string|null $regNumber
     * @param int|null $issueDate
     * @param int|null $expiryDate
     * @param int|null $numberOfDocuments
     * @param string|null $allowedDocumentFormat
     * @return Builder
     */
    public static function kycStartEvent(
        $sequenceId,
        $eventId,
        $userMerchantId,
        $verificationMode,
        $verificationSource,
        $consent,
        $eventTimestamp = null,
        $allowNaOcrInputs = null,
        $declineOnSingleStep = null,
        $backsideProof = null,
        $groupId = null,
        $country = null,
        $kycLanguage = null,
        $redirectUrl = null,
        $email = null,
        $firstName = null,
        $lastName = null,
        $profileId = null,
        $phone = null,
        $birthDate = null,
        $regNumber = null,
        $issueDate = null,
        $expiryDate = null,
        $numberOfDocuments = null,
        $allowedDocumentFormat = null
    ) {
        $envelopeType = 'kyc_start';
        $builder = new self($envelopeType, $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }
        return $builder
            ->addKycData(
                $eventId,
                $eventTimestamp,
                $groupId,
                null,
                null,
                null,
                null,
                null,
                null,
                $profileId,
                null,
                null,
                null,
                null,
                null,
                $regNumber,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $issueDate,
                $expiryDate,
                $verificationMode,
                $verificationSource,
                $consent,
                $allowNaOcrInputs,
                $declineOnSingleStep,
                $backsideProof,
                $kycLanguage,
                $redirectUrl,
                $numberOfDocuments,
                $allowedDocumentFormat
            )
            ->addUserData(
                $email,
                $userMerchantId,
                $phone,
                null,
                $firstName,
                $lastName,
                null,
                null,
                $country,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $birthDate,
                null,
                null,
                null,
                null,
                null,
                null
            );
    }

    /**
     * Returns builder for kyc_proof request
     *
     * @param int $kycStartId
     */
    public static function kycProofEvent($kycStartId)
    {
        $envelopeType = 'kyc_proof';
        $sequenceId = '';

        $builder = new self($envelopeType, $sequenceId);

        return $builder
            ->addKycProofData($kycStartId);
    }

    /**
     * Returns builder for order_item request
     *
     * @param string $sequenceId
     * @param float $amount
     * @param string $currency
     * @param string $eventId
     * @param int $eventTimestamp
     * @param string $orderType
     * @param string|null $transactionId
     * @param string|null $groupId
     * @param string|null $affiliateId
     * @param float|null $amountConverted
     * @param string|null $campaign
     * @param string|null $carrier
     * @param string|null $carrierShippingId
     * @param string|null $carrierUrl
     * @param string|null $carrierPhone
     * @param int|null $couponStartDate
     * @param int|null $couponEndDate
     * @param string|null $couponId
     * @param string|null $couponName
     * @param string|null $customerComment
     * @param int|null $deliveryEstimate
     * @param string|null $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $phone
     * @param string|null $productDescription
     * @param string|null $productName
     * @param int|null $productQuantity
     * @param string|null $shippingAddress
     * @param string|null $shippingCity
     * @param string|null $shippingCountry
     * @param string|null $shippingCurrency
     * @param float|null $shippingFee
     * @param float|null $shippingFeeConverted
     * @param string|null $shippingState
     * @param string|null $shippingZip
     * @param string|null $socialType
     * @param string|null $source
     * @param string|null $sourceFeeCurrency
     * @param float|null $sourceFee
     * @param float|null $sourceFeeConverted
     * @param string|null $taxCurrency
     * @param float|null $taxFee
     * @param float|null $taxFeeConverted
     * @param string|null $userMerchantId
     * @param string|null $websiteUrl
     * @param string|null $productUrl
     * @param string|null $productImageUrl
     * @return Builder
     */
    public static function orderItemEvent(
        $sequenceId,
        $amount,
        $currency,
        $eventId,
        $eventTimestamp,
        $orderType,
        $transactionId = null,
        $groupId = null,
        $affiliateId = null,
        $amountConverted = null,
        $campaign = null,
        $carrier = null,
        $carrierShippingId = null,
        $carrierUrl = null,
        $carrierPhone = null,
        $couponStartDate = null,
        $couponEndDate = null,
        $couponId = null,
        $couponName = null,
        $customerComment = null,
        $deliveryEstimate = null,
        $email = null,
        $firstName = null,
        $lastName = null,
        $phone = null,
        $productDescription = null,
        $productName = null,
        $productQuantity = null,
        $shippingAddress = null,
        $shippingCity = null,
        $shippingCountry = null,
        $shippingCurrency = null,
        $shippingFee = null,
        $shippingFeeConverted = null,
        $shippingState = null,
        $shippingZip = null,
        $socialType = null,
        $source = null,
        $sourceFeeCurrency = null,
        $sourceFee = null,
        $sourceFeeConverted = null,
        $taxCurrency = null,
        $taxFee = null,
        $taxFeeConverted = null,
        $userMerchantId = null,
        $websiteUrl = null,
        $productUrl = null,
        $productImageUrl = null
    ) {
        $envelopeType = 'order_item';
        $builder = new self($envelopeType, $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }
        return $builder
            ->addOrderData(
                $envelopeType,
                $amount,
                $currency,
                $eventId,
                $eventTimestamp,
                $transactionId,
                $groupId,
                null,
                $orderType,
                $amountConverted,
                $campaign,
                $carrier,
                $carrierShippingId,
                $carrierUrl,
                $carrierPhone,
                $couponStartDate,
                $couponEndDate,
                $couponId,
                $couponName,
                $customerComment,
                $deliveryEstimate,
                $shippingAddress,
                $shippingCity,
                $shippingCountry,
                $shippingCurrency,
                $shippingFee,
                $shippingFeeConverted,
                $shippingState,
                $shippingZip,
                $source,
                $sourceFee,
                $sourceFeeCurrency,
                $sourceFeeConverted,
                $taxCurrency,
                $taxFee,
                $taxFeeConverted,
                $productUrl,
                $productImageUrl
            )
            ->addUserData(
                $email,
                $userMerchantId,
                $phone,
                '',
                $firstName,
                $lastName,
                '',
                0,
                '',
                $socialType
            )
            -> addProductData(
                $productQuantity,
                $productName,
                $productDescription
            )
            ->addWebsiteData(
                $websiteUrl,
                null,
                $affiliateId
            );
    }

    /**
     * Returns builder for order_submit request
     *
     * @param string $sequenceId
     * @param float $amount
     * @param string $currency
     * @param string $eventId
     * @param int $eventTimestamp
     * @param int $itemsQuantity
     * @param string|null $transactionId
     * @param string|null $groupId
     * @param string|null $affiliateId
     * @param float|null $amountConverted
     * @param string|null $campaign
     * @param string|null $carrier
     * @param string|null $carrierShippingId
     * @param string|null $carrierUrl
     * @param string|null $carrierPhone
     * @param int|null $couponStartDate
     * @param int|null $couponEndDate
     * @param string|null $couponId
     * @param string|null $couponName
     * @param string|null $customerComment
     * @param int|null $deliveryEstimate
     * @param string|null $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $phone
     * @param string|null $shippingAddress
     * @param string|null $shippingCity
     * @param string|null $shippingCountry
     * @param string|null $shippingCurrency
     * @param float|null $shippingFee
     * @param float|null $shippingFeeConverted
     * @param string|null $shippingState
     * @param string|null $shippingZip
     * @param string|null $socialType
     * @param string|null $source
     * @param string|null $sourceFeeCurrency
     * @param float|null $sourceFee
     * @param float|null $sourceFeeConverted
     * @param string|null $taxCurrency
     * @param float|null $taxFee
     * @param float|null $taxFeeConverted
     * @param string|null $userMerchantId
     * @param string|null $websiteUrl
     * @param string|null $productUrl
     * @param string|null $productImageUrl
     * @return Builder
     */
    public static function orderSubmitEvent(
        $sequenceId,
        $amount,
        $currency,
        $eventId,
        $eventTimestamp,
        $itemsQuantity,
        $transactionId = null,
        $groupId = null,
        $affiliateId = null,
        $amountConverted = null,
        $campaign = null,
        $carrier = null,
        $carrierShippingId = null,
        $carrierUrl = null,
        $carrierPhone = null,
        $couponStartDate = null,
        $couponEndDate = null,
        $couponId = null,
        $couponName = null,
        $customerComment = null,
        $deliveryEstimate = null,
        $email = null,
        $firstName = null,
        $lastName = null,
        $phone = null,
        $shippingAddress = null,
        $shippingCity = null,
        $shippingCountry = null,
        $shippingCurrency = null,
        $shippingFee = null,
        $shippingFeeConverted = null,
        $shippingState = null,
        $shippingZip = null,
        $socialType = null,
        $source = null,
        $sourceFeeCurrency = null,
        $sourceFee = null,
        $sourceFeeConverted = null,
        $taxCurrency = null,
        $taxFee = null,
        $taxFeeConverted = null,
        $userMerchantId = null,
        $websiteUrl = null,
        $productUrl = null,
        $productImageUrl = null
    ) {
        $envelopeType = 'order_submit';
        $builder = new self($envelopeType, $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }
        return $builder
            ->addOrderData(
                $envelopeType,
                $amount,
                $currency,
                $eventId,
                $eventTimestamp,
                $transactionId,
                $groupId,
                $itemsQuantity,
                null,
                $amountConverted,
                $campaign,
                $carrier,
                $carrierShippingId,
                $carrierUrl,
                $carrierPhone,
                $couponStartDate,
                $couponEndDate,
                $couponId,
                $couponName,
                $customerComment,
                $deliveryEstimate,
                $shippingAddress,
                $shippingCity,
                $shippingCountry,
                $shippingCurrency,
                $shippingFee,
                $shippingFeeConverted,
                $shippingState,
                $shippingZip,
                $source,
                $sourceFee,
                $sourceFeeCurrency,
                $sourceFeeConverted,
                $taxCurrency,
                $taxFee,
                $taxFeeConverted,
                $productUrl,
                $productImageUrl
            )
            ->addUserData(
                $email,
                $userMerchantId,
                $phone,
                '',
                $firstName,
                $lastName,
                '',
                0,
                '',
                $socialType
            )
            ->addWebsiteData(
                $websiteUrl,
                null,
                $affiliateId
            );
    }

    /**
     * Returns builder for postback request
     *
     * @param int|null $requestId
     * @param string|null $transactionId
     * @param string|null $transactionStatus
     * @param string|null $code
     * @param string|null $reason
     * @param string|null $secure3d
     * @param string|null $avsResult
     * @param string|null $cvvResult
     * @param string|null $pspCode
     * @param string|null $pspReason
     * @param string|null $arn
     * @param string|null $paymentAccountId
     * @return Builder
     */
    public static function postBackEvent(
        $requestId =  null,
        $transactionId = null,
        $transactionStatus = null,
        $code = null,
        $reason = null,
        $secure3d = null,
        $avsResult = null,
        $cvvResult = null,
        $pspCode = null,
        $pspReason = null,
        $arn = null,
        $paymentAccountId = null
    ) {
        $builder = new self('postback', '');
        return $builder->addPostBackData(
            $requestId,
            $transactionId,
            $transactionStatus,
            $code,
            $reason,
            $secure3d,
            $avsResult,
            $cvvResult,
            $pspCode,
            $pspReason,
            $arn,
            $paymentAccountId
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
     * @param string|null $campaign
     *
     * @return $this
     */
    public function addWebsiteData($websiteUrl = null, $traffic_source = null, $affiliate_id = null, $campaign = null)
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
        if ($campaign !== null && !is_string($campaign)) {
            throw new \InvalidArgumentException('Campaign must be string');
        }

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
     * @param string|null $deviceId
     * @param string|null $ipList
     * @param string|null $plugins
     * @param string|null $refererUrl
     * @param string|null $originUrl
     * @param string|null $clientResolution
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
        $clientResolution = null
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
        if ($deviceId !== null && !is_string($deviceId)) {
            throw new \InvalidArgumentException('Device id must be string');
        }
        if ($ipList !== null && !is_string($ipList)) {
            throw new \InvalidArgumentException('Ip list must be string');
        }
        if ($plugins !== null && !is_string($plugins)) {
            throw new \InvalidArgumentException('Plugins must be string');
        }
        if ($refererUrl !== null && !is_string($refererUrl)) {
            throw new \InvalidArgumentException('Referer url must be string');
        }
        if ($originUrl !== null && !is_string($originUrl)) {
            throw new \InvalidArgumentException('Origin url must be string');
        }
        if ($clientResolution !== null && !is_string($clientResolution)) {
            throw new \InvalidArgumentException('Client resolution must be string');
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
        if ($userName !== null && !is_string($userName)) {
            throw new \InvalidArgumentException('User name must be string');
        }
        if ($password !== null && !is_string($password)) {
            throw new \InvalidArgumentException('Password must be string');
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
        if ($birthDate !== null && !is_int($birthDate)) {
            throw new \InvalidArgumentException('Birthdate timestamp must be integer');
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
        if ($fullname !== null && !is_string($fullname)) {
            throw new \InvalidArgumentException('Fullname must be string');
        }
        if ($state !== null && !is_string($state)) {
            throw new \InvalidArgumentException('State must be string');
        }
        if ($city !== null && !is_string($city)) {
            throw new \InvalidArgumentException('City must be string');
        }
        if ($address !== null && !is_string($address)) {
            throw new \InvalidArgumentException('Address must be string');
        }
        if ($zip !== null && !is_string($zip)) {
            throw new \InvalidArgumentException('Zip must be string');
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
     * @param string|null $merchantCountry
     * @param string|null $mcc
     * @param string|null $acquirerMerchantId
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
        $paymentAccountId = null,
        $merchantCountry = null,
        $mcc = null,
        $acquirerMerchantId = null
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

        if ($merchantCountry !== null && !is_string($merchantCountry)) {
            throw new \InvalidArgumentException('Merchant country must be string');
        }
        if ($mcc !== null && !is_string($mcc)) {
            throw new \InvalidArgumentException('MCC must be string');
        }
        if ($acquirerMerchantId !== null && !is_string($acquirerMerchantId)) {
            throw new \InvalidArgumentException('Acquirer merchant id be string');
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
        $this->replace('merchant_country', $merchantCountry);
        $this->replace('mcc', $mcc);
        $this->replace('acquirer_merchant_id', $acquirerMerchantId);

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
     * @param int|float $payoutAmount
     * @param string $payoutCurrency
     * @param string|null $payoutCardId
     * @param string|null $payoutAccountId
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
        $payoutAmount,
        $payoutCurrency,
        $payoutCardId =  null,
        $payoutAccountId = null,
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
        if (!is_float($payoutAmount) && !is_int($payoutAmount)) {
            throw new \InvalidArgumentException('Amount must be number');
        }
        if (!is_string($payoutCurrency)) {
            throw new \InvalidArgumentException('Payout currency must be string');
        }
        if ($payoutAccountId !== null && !is_string($payoutAccountId)) {
            throw new \InvalidArgumentException('Account ID must be string');
        }
        if ($payoutCardId !== null && !is_string($payoutCardId)) {
            throw new \InvalidArgumentException('Card ID must be string');
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
        $this->replace('payout_account_id', $payoutAccountId);
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
     * @param string|null $refundMethod
     * @param string|null $refundSystem
     * @param string|null $refundMid
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
        $agentId = null,
        $refundMethod = null,
        $refundSystem = null,
        $refundMid = null
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
        if ($refundMethod !== null && !is_string($refundMethod)) {
            throw new \InvalidArgumentException('Refund method must be string');
        }
        if ($refundSystem !== null && !is_string($refundSystem)) {
            throw new \InvalidArgumentException('Refund system must be string');
        }
        if ($refundMid !== null && !is_string($refundMid)) {
            throw new \InvalidArgumentException('Refund mid must be string');
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
        $this->replace('refund_method', $refundMethod);
        $this->replace('refund_system', $refundSystem);
        $this->replace('refund_mid', $refundMid);

        return $this;
    }

    /**
     * Provides transfer information to envelope
     *
     * @param string $eventId
     * @param int $eventTimestamp
     * @param float $amount
     * @param string $currency
     * @param string $accountId
     * @param string $secondAccountId
     * @param string $accountSystem
     * @param float|null $amountConverted
     * @param string|null $method
     * @param string|null $operation
     * @param string|null $secondEmail
     * @param string|null $secondPhone
     * @param string|int $secondBirthDate
     * @param string|null $secondFirstname
     * @param string|null $secondLastname
     * @param string|null $secondFullname
     * @param string|null $secondState
     * @param string|null $secondCity
     * @param string|null $secondAddress
     * @param string|null $secondZip
     * @param string|null $secondGender
     * @param string|null $secondCountry
     * @param string|null $iban
     * @param string|null $secondIban
     * @param string|null $bic
     * @param string|null $source
     * @param string|null $secondUserMerchantId
     *
     * @return $this
     */
    public function addTransferData(
        $eventId,
        $eventTimestamp,
        $amount,
        $currency,
        $accountId,
        $secondAccountId,
        $accountSystem,
        $amountConverted = null,
        $method = null,
        $operation = null,
        $secondEmail = null,
        $secondPhone = null,
        $secondBirthDate = null,
        $secondFirstname = null,
        $secondLastname = null,
        $secondFullname = null,
        $secondState = null,
        $secondCity = null,
        $secondAddress = null,
        $secondZip = null,
        $secondGender = null,
        $secondCountry = null,
        $iban = null,
        $secondIban = null,
        $bic = null,
        $source = null,
        $secondUserMerchantId = null
    ) {
        if (!is_string($eventId)) {
            throw new \InvalidArgumentException('Event ID must be string');
        }
        if (!is_int($eventTimestamp)) {
            throw new \InvalidArgumentException('Event timestamp must be int');
        }
        if (!is_int($amount) && !is_float($amount)) {
            throw new \InvalidArgumentException('Amount must be number');
        }
        if (!is_string($currency)) {
            throw new \InvalidArgumentException('Currency must be string');
        }
        if ($accountId !== null && !is_string($accountId)) {
            throw new \InvalidArgumentException('Account id must be string');
        }
        if ($secondAccountId !== null && !is_string($secondAccountId)) {
            throw new \InvalidArgumentException('Second account id must be string');
        }
        if ($accountSystem !== null && !is_string($accountSystem)) {
            throw new \InvalidArgumentException('Account system must be string');
        }
        if ($amountConverted !== null && !is_int($amountConverted) && !is_float($amountConverted)) {
            throw new \InvalidArgumentException('Amount converted must be number');
        }
        if ($method !== null && !is_string($method)) {
            throw new \InvalidArgumentException('Method must be string');
        }
        if ($operation !== null && !is_string($operation)) {
            throw new \InvalidArgumentException('Operation must be string');
        }
        if ($secondPhone !== null && !is_string($secondPhone)) {
            throw new \InvalidArgumentException('Second phone must be string');
        }
        if ($secondEmail !== null && !is_string($secondEmail)) {
            throw new \InvalidArgumentException('Second email must be string');
        }
        if ($secondBirthDate !== null && !is_int($secondBirthDate)) {
            throw new \InvalidArgumentException('Second birth date must be int');
        }
        if ($secondFirstname !== null && !is_string($secondFirstname)) {
            throw new \InvalidArgumentException('Second firstname must be string');
        }
        if ($secondLastname !== null && !is_string($secondLastname)) {
            throw new \InvalidArgumentException('Second lastname must be string');
        }
        if ($secondFullname !== null && !is_string($secondFullname)) {
            throw new \InvalidArgumentException('Second fullname must be string');
        }
        if ($secondState !== null && !is_string($secondState)) {
            throw new \InvalidArgumentException('Second state must be string');
        }
        if ($secondCity !== null && !is_string($secondCity)) {
            throw new \InvalidArgumentException('Second city must be string');
        }
        if ($secondAddress !== null && !is_string($secondAddress)) {
            throw new \InvalidArgumentException('Second address must be string');
        }
        if ($secondZip !== null && !is_string($secondZip)) {
            throw new \InvalidArgumentException('Second zip must be string');
        }
        if ($secondGender !== null && !is_string($secondGender)) {
            throw new \InvalidArgumentException('Second gender must be string');
        }
        if ($secondCountry !== null && !is_string($secondCountry)) {
            throw new \InvalidArgumentException('Second country must be string');
        }
        if ($iban !== null && !is_string($iban)) {
            throw new \InvalidArgumentException('Iban must be string');
        }
        if ($secondIban !== null && !is_string($secondIban)) {
            throw new \InvalidArgumentException('Second iban must be string');
        }
        if ($bic !== null && !is_string($bic)) {
            throw new \InvalidArgumentException('Bic must be string');
        }
        if ($source !== null && !is_string($source)) {
            throw new \InvalidArgumentException('Transfer source must be string');
        }
        if ($source !== null && !is_string($secondUserMerchantId)) {
            throw new \InvalidArgumentException('Transfer second user merchant id must be string');
        }

        $this->replace('event_id', $eventId);
        $this->replace('event_timestamp', $eventTimestamp);
        $this->replace('amount', $amount);
        $this->replace('currency', $currency);
        $this->replace('account_id', $accountId);
        $this->replace('second_account_id', $secondAccountId);
        $this->replace('account_system', $accountSystem);
        $this->replace('amount_converted', $amountConverted);
        $this->replace('method', $method);
        $this->replace('operation', $operation);
        $this->replace('second_email', $secondEmail);
        $this->replace('second_phone', $secondPhone);
        $this->replace('second_birth_date', $secondBirthDate);
        $this->replace('second_firstname', $secondFirstname);
        $this->replace('second_lastname', $secondLastname);
        $this->replace('second_fullname', $secondFullname);
        $this->replace('second_state', $secondState);
        $this->replace('second_city', $secondCity);
        $this->replace('second_address', $secondAddress);
        $this->replace('second_zip', $secondZip);
        $this->replace('second_gender', $secondGender);
        $this->replace('second_country', $secondCountry);
        $this->replace('iban', $iban);
        $this->replace('second_iban', $secondIban);
        $this->replace('bic', $bic);
        $this->replace('transfer_source', $source);
        $this->replace('second_user_merchant_id', $secondUserMerchantId);

        return $this;
    }

    /**
     * Provides kyc information to envelope
     *
     * @param string $eventId
     * @param int $eventTimestamp
     * @param string|null $groupId
     * @param string|null $status
     * @param string|null $code
     * @param string|null $reason
     * @param string|null $providerResult
     * @param string|null $providerCode
     * @param string|null $providerReason
     * @param string|null $profileId
     * @param string|null $profileType
     * @param string|null $profileSubType
     * @param string|null $industry
     * @param string|null $description
     * @param int|null $regDate
     * @param string|null $regNumber
     * @param string|null $vatNumber
     * @param string|null $secondCountry
     * @param string|null $secondState
     * @param string|null $secondCity
     * @param string|null $secondAddress
     * @param string|null $secondZip
     * @param string|null $providerId
     * @param string|null $contactEmail
     * @param string|null $contactPhone
     * @param string|null $walletType
     * @param string|null $nationality
     * @param bool|null $finalBeneficiary
     * @param string|null $employmentStatus
     * @param string|null $sourceOfFunds
     * @param int|null $issueDate
     * @param int|null $expiryDate
     * @param string|null $verificationMode
     * @param string|null $verificationSource
     * @param bool|null $consent
     * @param bool|null $allowNaOcrInputs
     * @param bool|null $declineOnSingleStep
     * @param bool|null $backsideProof
     * @param string|null $kycLanguage
     * @param string|null $redirectUrl
     * @param int|null $numberOfDocuments
     * @param string|null $allowedDocumentFormat
     * @return $this
     */
    public function addKycData(
        $eventId,
        $eventTimestamp,
        $groupId = null,
        $status = null,
        $code = null,
        $reason = null,
        $providerResult = null,
        $providerCode = null,
        $providerReason = null,
        $profileId = null,
        $profileType = null,
        $profileSubType = null,
        $industry = null,
        $description = null,
        $regDate = null,
        $regNumber = null,
        $vatNumber = null,
        $secondCountry = null,
        $secondState = null,
        $secondCity = null,
        $secondAddress = null,
        $secondZip = null,
        $providerId = null,
        $contactEmail = null,
        $contactPhone = null,
        $walletType = null,
        $nationality = null,
        $finalBeneficiary = null,
        $employmentStatus = null,
        $sourceOfFunds = null,
        $issueDate = null,
        $expiryDate = null,
        $verificationMode = null,
        $verificationSource = null,
        $consent = null,
        $allowNaOcrInputs = null,
        $declineOnSingleStep = null,
        $backsideProof = null,
        $kycLanguage = null,
        $redirectUrl = null,
        $numberOfDocuments = null,
        $allowedDocumentFormat = null
    ) {
        if (!is_string($eventId)) {
            throw new \InvalidArgumentException('Event ID must be string');
        }
        if (!is_int($eventTimestamp)) {
            throw new \InvalidArgumentException('Event timestamp must be int');
        }
        if ($groupId !== null && !is_string($groupId)) {
            throw new \InvalidArgumentException('Group id must be string');
        }
        if ($status !== null && !is_string($status)) {
            throw new \InvalidArgumentException('Status must be string');
        }
        if ($code !== null && !is_string($code)) {
            throw new \InvalidArgumentException('Code must be string');
        }
        if ($reason !== null && !is_string($reason)) {
            throw new \InvalidArgumentException('Reason must be string');
        }
        if ($providerResult !== null && !is_string($providerResult)) {
            throw new \InvalidArgumentException('Provider result must be string');
        }
        if ($providerCode !== null && !is_string($providerCode)) {
            throw new \InvalidArgumentException('Provider code must be string');
        }
        if ($providerReason !== null && !is_string($providerReason)) {
            throw new \InvalidArgumentException('Provider reason must be string');
        }
        if ($profileId !== null && !is_string($profileId)) {
            throw new \InvalidArgumentException('Profile id must be string');
        }
        if ($profileType !== null && !is_string($profileType)) {
            throw new \InvalidArgumentException('Profile type must be string');
        }
        if ($profileSubType !== null && !is_string($profileSubType)) {
            throw new \InvalidArgumentException('Profile sub type must be string');
        }
        if ($industry !== null && !is_string($industry)) {
            throw new \InvalidArgumentException('Industry must be string');
        }
        if ($description !== null && !is_string($description)) {
            throw new \InvalidArgumentException('Description must be string');
        }
        if ($regDate !== null && !is_int($regDate)) {
            throw new \InvalidArgumentException('Reg date must be integer');
        }
        if ($regNumber !== null && !is_string($regNumber)) {
            throw new \InvalidArgumentException('Reg number must be string');
        }
        if ($vatNumber !== null && !is_string($vatNumber)) {
            throw new \InvalidArgumentException('Vat number must be string');
        }
        if ($secondCountry !== null && !is_string($secondCountry)) {
            throw new \InvalidArgumentException('Secondary country must be string');
        }
        if ($secondState !== null && !is_string($secondState)) {
            throw new \InvalidArgumentException('Second state must be string');
        }
        if ($secondCity !== null && !is_string($secondCity)) {
            throw new \InvalidArgumentException('Second city must be string');
        }
        if ($secondAddress !== null && !is_string($secondAddress)) {
            throw new \InvalidArgumentException('Second address must be string');
        }
        if ($secondZip !== null && !is_string($secondZip)) {
            throw new \InvalidArgumentException('Second zip must be string');
        }
        if ($providerId !== null && !is_string($providerId)) {
            throw new \InvalidArgumentException('Provider id must be string');
        }
        if ($contactEmail !== null && !is_string($contactEmail)) {
            throw new \InvalidArgumentException('Contact email must be string');
        }
        if ($contactPhone !== null && !is_string($contactPhone)) {
            throw new \InvalidArgumentException('Contact phone must be string');
        }
        if ($walletType !== null && !is_string($walletType)) {
            throw new \InvalidArgumentException('Wallet type must be string');
        }
        if ($nationality !== null && !is_string($nationality)) {
            throw new \InvalidArgumentException('Nationality must be string');
        }
        if ($finalBeneficiary !== null && !is_bool($finalBeneficiary)) {
            throw new \InvalidArgumentException('Final beneficiary must be boolean');
        }
        if ($employmentStatus !== null && !is_string($employmentStatus)) {
            throw new \InvalidArgumentException('Employment status must be string');
        }
        if ($sourceOfFunds !== null && !is_string($sourceOfFunds)) {
            throw new \InvalidArgumentException('Source of funds must be string');
        }
        if ($issueDate !== null && !is_int($issueDate)) {
            throw new \InvalidArgumentException('Issue date must be integer');
        }
        if ($expiryDate !== null && !is_int($expiryDate)) {
            throw new \InvalidArgumentException('Expiry date must be integer');
        }
        if ($verificationMode !== null && !is_string($verificationMode)) {
            throw new \InvalidArgumentException('Verification mode must be string');
        }
        if ($verificationSource !== null && !is_string($verificationSource)) {
            throw new \InvalidArgumentException('Verification source must be string');
        }
        if ($consent !== null && !is_bool($consent)) {
            throw new \InvalidArgumentException('Consent must be boolean');
        }
        if ($allowNaOcrInputs !== null && !is_bool($allowNaOcrInputs)) {
            throw new \InvalidArgumentException('Allow na ocr inputs must be boolean');
        }
        if ($declineOnSingleStep !== null && !is_bool($declineOnSingleStep)) {
            throw new \InvalidArgumentException('Decline on single step must be boolean');
        }
        if ($backsideProof !== null && !is_bool($backsideProof)) {
            throw new \InvalidArgumentException('Backside proof must be boolean');
        }
        if ($kycLanguage !== null && !is_string($kycLanguage)) {
            throw new \InvalidArgumentException('Kyc language must be string');
        }
        if ($redirectUrl !== null && !is_string($redirectUrl)) {
            throw new \InvalidArgumentException('Redirect url must be string');
        }
        if ($numberOfDocuments !== null && !in_array($numberOfDocuments, [0, 1, 2])) {
            throw new \InvalidArgumentException('Incorrect value. Number Of Documents must contains 0, 1 or 2');
        }
        if ($allowedDocumentFormat !== null && !is_string($allowedDocumentFormat)) {
            throw new \InvalidArgumentException('Allowed document format must be string');
        }

        $this->replace('event_id', $eventId);
        $this->replace('event_timestamp', $eventTimestamp);
        $this->replace('group_id', $groupId);
        $this->replace('status', $status);
        $this->replace('code', $code);
        $this->replace('reason', $reason);
        $this->replace('provider_result', $providerResult);
        $this->replace('provider_code', $providerCode);
        $this->replace('provider_reason', $providerReason);
        $this->replace('profile_id', $profileId);
        $this->replace('profile_type', $profileType);
        $this->replace('profile_sub_type', $profileSubType);
        $this->replace('industry', $industry);
        $this->replace('description', $description);
        $this->replace('reg_date', $regDate);
        $this->replace('reg_number', $regNumber);
        $this->replace('vat_number', $vatNumber);
        $this->replace('second_country', $secondCountry);
        $this->replace('second_state', $secondState);
        $this->replace('second_city', $secondCity);
        $this->replace('second_address', $secondAddress);
        $this->replace('second_zip', $secondZip);
        $this->replace('provider_id', $providerId);
        $this->replace('contact_email', $contactEmail);
        $this->replace('contact_phone', $contactPhone);
        $this->replace('wallet_type', $walletType);
        $this->replace('nationality', $nationality);
        $this->replace('final_beneficiary', $finalBeneficiary);
        $this->replace('employment_status', $employmentStatus);
        $this->replace('source_of_funds', $sourceOfFunds);
        $this->replace('issue_date', $issueDate);
        $this->replace('expiry_date', $expiryDate);
        $this->replace('verification_mode', $verificationMode);
        $this->replace('verification_source', $verificationSource);
        $this->replace('consent', $consent);
        $this->replace('allow_na_ocr_inputs', $allowNaOcrInputs);
        $this->replace('decline_on_single_step', $declineOnSingleStep);
        $this->replace('backside_proof', $backsideProof);
        $this->replace('kyc_language', $kycLanguage);
        $this->replace('redirect_url', $redirectUrl);
        $this->replace('number_of_documents', $numberOfDocuments);
        $this->replace('allowed_document_format', $allowedDocumentFormat);

        return $this;
    }

    /**
     * Provides order information to envelope
     *
     * @param string $envelopeType
     * @param float $amount
     * @param string $currency
     * @param string $eventId
     * @param int $eventTimestamp
     * @param string|null $transactionId
     * @param string|null $groupId
     * @param int|null $itemsQuantity
     * @param string|null $orderType
     * @param float|null $amountConverted
     * @param string|null $campaign
     * @param string|null $carrier
     * @param string|null $carrierShippingId
     * @param string|null $carrierUrl
     * @param string|null $carrierPhone
     * @param int|null $couponStartDate
     * @param int|null $couponEndDate
     * @param string|null $couponId
     * @param string|null $couponName
     * @param string|null $customerComment
     * @param int|null $deliveryEstimate
     * @param string|null $shippingAddress
     * @param string|null $shippingCity
     * @param string|null $shippingCountry
     * @param string|null $shippingCurrency
     * @param float|null $shippingFee
     * @param float|null $shippingFeeConverted
     * @param string|null $shippingState
     * @param string|null $shippingZip
     * @param string|null $source
     * @param float|null $sourceFee
     * @param string|null $sourceFeeCurrency
     * @param float|null $sourceFeeConverted
     * @param string|null $taxCurrency
     * @param float|null $taxFee
     * @param float|null $taxFeeConverted
     * @param string|null $productUrl
     * @param string|null $productImageUrl
     * @return Builder
     */
    public function addOrderData(
        $envelopeType,
        $amount,
        $currency,
        $eventId,
        $eventTimestamp,
        $transactionId = null,
        $groupId = null,
        $itemsQuantity = null,
        $orderType = null,
        $amountConverted = null,
        $campaign = null,
        $carrier = null,
        $carrierShippingId = null,
        $carrierUrl = null,
        $carrierPhone = null,
        $couponStartDate = null,
        $couponEndDate = null,
        $couponId = null,
        $couponName = null,
        $customerComment = null,
        $deliveryEstimate = null,
        $shippingAddress = null,
        $shippingCity = null,
        $shippingCountry = null,
        $shippingCurrency = null,
        $shippingFee = null,
        $shippingFeeConverted = null,
        $shippingState = null,
        $shippingZip = null,
        $source = null,
        $sourceFee = null,
        $sourceFeeCurrency = null,
        $sourceFeeConverted = null,
        $taxCurrency = null,
        $taxFee = null,
        $taxFeeConverted = null,
        $productUrl = null,
        $productImageUrl = null
    ) {
        if (!is_string($envelopeType)) {
            throw new \InvalidArgumentException('Envelope type must be string');
        }
        if (!is_int($amount) && !is_float($amount)) {
            throw new \InvalidArgumentException('Amount must be number');
        }
        if (!is_string($currency)) {
            throw new \InvalidArgumentException('Currency must be string');
        }
        if (!is_string($eventId)) {
            throw new \InvalidArgumentException('Event ID must be string');
        }
        if (!is_int($eventTimestamp)) {
            throw new \InvalidArgumentException('Event timestamp must be int');
        }
        if ($envelopeType === 'order_submit' && !is_int($itemsQuantity)) {
            throw new \InvalidArgumentException('Items quantity must be int');
        }
        if ($envelopeType === 'order_item' && !is_string($orderType)) {
            throw new \InvalidArgumentException('Order type must be string');
        }
        if ($transactionId !== null && !is_string($transactionId)) {
            throw new \InvalidArgumentException('Transaction id must be string');
        }
        if ($groupId !== null && !is_string($groupId)) {
            throw new \InvalidArgumentException('Group id must be string');
        }
        if ($amountConverted !== null && !is_int($amountConverted) && !is_float($amountConverted)) {
            throw new \InvalidArgumentException('Amount converted must be number');
        }
        if ($campaign !== null && !is_string($campaign)) {
            throw new \InvalidArgumentException('Campaign must be string');
        }
        if ($carrier !== null && !is_string($carrier)) {
            throw new \InvalidArgumentException('Carrier must be string');
        }
        if ($carrierShippingId !== null && !is_string($carrierShippingId)) {
            throw new \InvalidArgumentException('Carrier shipping id must be string');
        }
        if ($carrierUrl !== null && !is_string($carrierUrl)) {
            throw new \InvalidArgumentException('Carrier url must be string');
        }
        if ($carrierPhone !== null && !is_string($carrierPhone)) {
            throw new \InvalidArgumentException('Carrier phone must be string');
        }
        if ($couponStartDate !== null && !is_int($couponStartDate)) {
            throw new \InvalidArgumentException('Coupon start date must be int');
        }
        if ($couponEndDate !== null && !is_int($couponEndDate)) {
            throw new \InvalidArgumentException('Coupon end date must be int');
        }
        if ($couponId !== null && !is_string($couponId)) {
            throw new \InvalidArgumentException('Coupon id must be string');
        }
        if ($couponName !== null && !is_string($couponName)) {
            throw new \InvalidArgumentException('Coupon name must be string');
        }
        if ($customerComment !== null && !is_string($customerComment)) {
            throw new \InvalidArgumentException('Customer comment must be string');
        }
        if ($deliveryEstimate !== null && !is_int($deliveryEstimate)) {
            throw new \InvalidArgumentException('Delivery estimate must be int');
        }
        if ($shippingAddress !== null && !is_string($shippingAddress)) {
            throw new \InvalidArgumentException('Shipping address must be string');
        }
        if ($shippingCity !== null && !is_string($shippingCity)) {
            throw new \InvalidArgumentException('Shipping city must be string');
        }
        if ($shippingCountry !== null && !is_string($shippingCountry)) {
            throw new \InvalidArgumentException('Shipping country must be string');
        }
        if ($shippingCurrency !== null && !is_string($shippingCurrency)) {
            throw new \InvalidArgumentException('Shipping currency must be string');
        }
        if ($shippingFee !== null && !is_int($shippingFee) && !is_float($shippingFee)) {
            throw new \InvalidArgumentException('Shipping fee must be number');
        }
        if ($shippingFeeConverted !== null && !is_int($shippingFeeConverted) && !is_float($shippingFeeConverted)) {
            throw new \InvalidArgumentException('Shipping fee converted must be number');
        }
        if ($shippingState !== null && !is_string($shippingState)) {
            throw new \InvalidArgumentException('Shipping state must be string');
        }
        if ($shippingZip !== null && !is_string($shippingZip)) {
            throw new \InvalidArgumentException('Shipping zip must be string');
        }
        if ($source !== null && !is_string($source)) {
            throw new \InvalidArgumentException('Order source must be string');
        }
        if ($sourceFee !== null && !is_int($sourceFee) && !is_float($sourceFee)) {
            throw new \InvalidArgumentException('Source fee must be number');
        }
        if ($sourceFeeConverted !== null && !is_int($sourceFeeConverted) && !is_float($sourceFeeConverted)) {
            throw new \InvalidArgumentException('Source fee converted must be number');
        }
        if ($sourceFeeCurrency !== null && !is_string($sourceFeeCurrency)) {
            throw new \InvalidArgumentException('Source fee currency must be string');
        }
        if ($taxCurrency !== null && !is_string($taxCurrency)) {
            throw new \InvalidArgumentException('Tax currency must be string');
        }
        if ($taxFee !== null && !is_int($taxFee) && !is_float($taxFee)) {
            throw new \InvalidArgumentException('Tax fee must be number');
        }
        if ($taxFeeConverted !== null && !is_int($taxFeeConverted) && !is_float($taxFeeConverted)) {
            throw new \InvalidArgumentException('Tax fee converted must be number');
        }
        if ($productUrl !== null && !is_string($productUrl)) {
            throw new \InvalidArgumentException('Product url must be string');
        }
        if ($productImageUrl !== null && !is_string($productImageUrl)) {
            throw new \InvalidArgumentException('Product image url must be string');
        }
        if ($productImageUrl !== null && !is_string($productImageUrl)) {
            throw new \InvalidArgumentException('Product image url must be string');
        }
        $this->replace('amount', $amount);
        $this->replace('currency', $currency);
        $this->replace('event_id', $eventId);
        $this->replace('event_timestamp', $eventTimestamp);
        $this->replace('items_quantity', $itemsQuantity);
        $this->replace('order_type', $orderType);
        $this->replace('transaction_id', $transactionId);
        $this->replace('group_id', $groupId);
        $this->replace('amount_converted', $amountConverted);
        $this->replace('campaign', $campaign);
        $this->replace('carrier', $carrier);
        $this->replace('carrier_shipping_id', $carrierShippingId);
        $this->replace('carrier_url', $carrierUrl);
        $this->replace('carrier_phone', $carrierPhone);
        $this->replace('coupon_start_date', $couponStartDate);
        $this->replace('coupon_end_date', $couponEndDate);
        $this->replace('coupon_id', $couponId);
        $this->replace('coupon_name', $couponName);
        $this->replace('customer_comment', $customerComment);
        $this->replace('delivery_estimate', $deliveryEstimate);
        $this->replace('shipping_address', $shippingAddress);
        $this->replace('shipping_city', $shippingCity);
        $this->replace('shipping_country', $shippingCountry);
        $this->replace('shipping_currency', $shippingCurrency);
        $this->replace('shipping_fee', $shippingFee);
        $this->replace('shipping_fee_converted', $shippingFeeConverted);
        $this->replace('shipping_state', $shippingState);
        $this->replace('shipping_zip', $shippingZip);
        $this->replace('order_source', $source);
        $this->replace('source_fee', $sourceFee);
        $this->replace('source_fee_currency', $sourceFeeCurrency);
        $this->replace('source_fee_converted', $sourceFeeConverted);
        $this->replace('tax_currency', $taxCurrency);
        $this->replace('tax_fee', $taxFee);
        $this->replace('tax_fee_converted', $taxFeeConverted);
        $this->replace('product_url', $productUrl);
        $this->replace('product_image_url', $productImageUrl);

        return $this;
    }

    /**
     * Provides postback information to envelope
     *
     * @param int|null $requestId
     * @param string|null $transactionId
     * @param string|null $transactionStatus
     * @param string|null $code
     * @param string|null $reason
     * @param string|null $secure3d
     * @param string|null $avsResult
     * @param string|null $cvvResult
     * @param string|null $pspCode
     * @param string|null $pspReason
     * @param string|null $arn
     * @param string|null $paymentAccountId
     * @return $this
     */
    public function addPostbackData(
        $requestId = null,
        $transactionId = null,
        $transactionStatus = null,
        $code = null,
        $reason = null,
        $secure3d = null,
        $avsResult = null,
        $cvvResult = null,
        $pspCode = null,
        $pspReason = null,
        $arn = null,
        $paymentAccountId = null
    ) {
        if ($requestId === null && $transactionId === null) {
            throw new \InvalidArgumentException('request_id or transaction_id should be provided');
        }
        if ($transactionId !== null && !is_string($transactionId)) {
            throw new \InvalidArgumentException('TransactionId must be string');
        }
        if ($requestId !== null && !is_int($requestId)) {
            throw new \InvalidArgumentException('RequestId must be int');
        }
        if ($transactionStatus !== null && !is_string($transactionStatus)) {
            throw new \InvalidArgumentException('Transaction status must be string');
        }
        if ($code !== null && !is_string($code)) {
            throw new \InvalidArgumentException('Code must be string');
        }
        if ($reason !== null && !is_string($reason)) {
            throw new \InvalidArgumentException('Reason must be string');
        }
        if ($secure3d !== null && !is_string($secure3d)) {
            throw new \InvalidArgumentException('Secure3d must be string');
        }
        if ($avsResult !== null && !is_string($avsResult)) {
            throw new \InvalidArgumentException('AvsResult must be string');
        }
        if ($cvvResult !== null && !is_string($cvvResult)) {
            throw new \InvalidArgumentException('CvvResult must be string');
        }
        if ($pspCode !== null && !is_string($pspCode)) {
            throw new \InvalidArgumentException('PspCode must be string');
        }
        if ($pspReason !== null && !is_string($pspReason)) {
            throw new \InvalidArgumentException('PspReason must be string');
        }
        if ($arn !== null && !is_string($arn)) {
            throw new \InvalidArgumentException('Arn must be string');
        }
        if ($paymentAccountId !== null && !is_string($paymentAccountId)) {
            throw new \InvalidArgumentException('PaymentAccoutId must be string');
        }

        $this->replace('request_id', $requestId);
        $this->replace('transaction_id', $transactionId);
        $this->replace('transaction_status', $transactionStatus);
        $this->replace('code', $code);
        $this->replace('reason', $reason);
        $this->replace('secure3d', $secure3d);
        $this->replace('avs_result', $avsResult);
        $this->replace('cvv_result', $cvvResult);
        $this->replace('psp_code', $pspCode);
        $this->replace('psp_reason', $pspReason);
        $this->replace('arn', $arn);
        $this->replace('payment_account_id', $paymentAccountId);

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

    /**
     * Provides group id value to envelope
     *
     * @param string|null $groupId
     * @return $this
     */
    public function addGroupId($groupId = null)
    {
        if ($groupId !== null && !is_string($groupId)) {
            throw new \InvalidArgumentException('Group id must be string');
        }
        $this->replace('group_id', $groupId);

        return $this;
    }

    /**
     * Provides kycProof value to envelope
     *
     * @param int $kycStartId
     * @return $this
     */
    public function addKycProofData($kycStartId)
    {
        if (!is_int($kycStartId)) {
            throw new \InvalidArgumentException('KycStartId must be integer');
        }

        $this->replace('kyc_start_id', $kycStartId);

        return $this;
    }


}
