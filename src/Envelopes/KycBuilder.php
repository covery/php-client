<?php

namespace Covery\Client\Envelopes;

/**
 * KYC-related envelope builder methods, split out of Builder to reduce its size.
 */
trait KycBuilder
{
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
     * @param string|null $linksToDocuments
     * @param array|null $documentId
     * @param bool|null $addressConfirmed
     * @param bool|null $secondAddressConfirmed
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
        $gender = null,
        $linksToDocuments = null,
        $documentId = null,
        $addressConfirmed = null,
        $secondAddressConfirmed = null
    ) {
        $builder = new Builder('kyc_profile', $sequenceId);
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
                $expiryDate,
                NULL,
                NULL,
                NULL,
                NULL,
                NULL,
                NULL,
                NULL,
                NULL,
                NULL,
                NULL,
                $addressConfirmed,
                $secondAddressConfirmed
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
            ->addWebsiteData($websiteUrl)
            ->addLinksToDocuments($linksToDocuments)
            ->addDocumentData($documentId);
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
     * @param string|null $linksToDocuments
     * @param array|null $documentId
     * @param bool|null $addressConfirmed
     * @param bool|null $secondAddressConfirmed
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
        $providerReason = null,
        $linksToDocuments = null,
        $providerId = null,
        $profileId = null,
        $profileType = null,
        $profileSubType = null,
        $firstName = null,
        $lastName = null,
        $fullName = null,
        $gender = null,
        $industry = null,
        $walletType = null,
        $websiteUrl = null,
        $description = null,
        $employmentStatus = null,
        $sourceOfFunds = null,
        $birthDate = null,
        $regDate = null,
        $issueDate = null,
        $expiryDate = null,
        $regNumber = null,
        $vatNumber = null,
        $email = null,
        $emailConfirmed = null,
        $phone = null,
        $phoneConfirmed = null,
        $contactEmail = null,
        $contactPhone = null,
        $country = null,
        $state = null,
        $city = null,
        $address = null,
        $zip = null,
        $nationality = null,
        $secondCountry = null,
        $secondState = null,
        $secondCity = null,
        $secondAddress = null,
        $secondZip = null,
        $ajaxValidation = null,
        $cookieEnabled = null,
        $cpuClass = null,
        $deviceFingerprint = null,
        $deviceId = null,
        $doNotTrack = null,
        $ip = null,
        $realIp = null,
        $localIpList = null,
        $language = null,
        $languages = null,
        $languageBrowser = null,
        $languageUser = null,
        $languageSystem = null,
        $os = null,
        $screenResolution = null,
        $screenOrientation = null,
        $clientResolution = null,
        $timezoneOffset = null,
        $userAgent = null,
        $plugins = null,
        $refererUrl = null,
        $originUrl = null,
        $documentId = null,
        $addressConfirmed = null,
        $secondAddressConfirmed = null,
        $anonymous = null
    ) {
        $builder = new Builder('kyc_submit', $sequenceId);
        if ($eventTimestamp === null) {
            $eventTimestamp = time();
        }
        return $builder
            ->addKycSubmitData(
                $eventId,
                $eventTimestamp,
                $groupId,
                $status,
                $code,
                $reason,
                $providerId,
                $providerResult,
                $providerCode,
                $providerReason,
                $profileId,
                $profileType,
                $profileSubType,
                $firstName,
                $lastName,
                $fullName,
                $gender,
                $industry,
                $walletType,
                $websiteUrl,
                $description,
                $employmentStatus,
                $sourceOfFunds,
                $birthDate,
                $regDate,
                $issueDate,
                $expiryDate,
                $regNumber,
                $vatNumber,
                $email,
                $emailConfirmed,
                $phone,
                $phoneConfirmed,
                $contactEmail,
                $contactPhone,
                $country,
                $state,
                $city,
                $address,
                $zip,
                $nationality,
                $secondCountry,
                $secondState,
                $secondCity,
                $secondAddress,
                $secondZip,
                $ajaxValidation,
                $cookieEnabled,
                $cpuClass,
                $deviceFingerprint,
                $deviceId,
                $doNotTrack,
                $ip,
                $realIp,
                $localIpList,
                $language,
                $languages,
                $languageBrowser,
                $languageUser,
                $languageSystem,
                $os,
                $screenResolution,
                $screenOrientation,
                $clientResolution,
                $timezoneOffset,
                $userAgent,
                $plugins,
                $refererUrl,
                $originUrl,
                $addressConfirmed,
                $secondAddressConfirmed,
                $anonymous
            )
            ->addUserData(
                null,
                $userId
            )
            ->addLinksToDocuments($linksToDocuments)
            ->addDocumentData($documentId);
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
     * @param int|null $birthDate
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
        $builder = new Builder($envelopeType, $sequenceId);
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
                $allowedDocumentFormat,
                null,
                null
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
        $sequenceId = '';

        $builder = new Builder(Builder::EVENT_KYC_PROOF, $sequenceId);

        return $builder
            ->addKycProofData($kycStartId);
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
     * @param bool|null $addressConfirmed
     * @param bool|null $secondAddressConfirmed
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
        $allowedDocumentFormat = null,
        $addressConfirmed = null,
        $secondAddressConfirmed = null
    ) {
        $this->assertString($eventId, 'Event ID must be string');
        $this->assertInt($eventTimestamp, 'Event timestamp must be int');
        $this->assertOptionalString($groupId, 'Group id must be string');
        $this->assertOptionalString($status, 'Status must be string');
        $this->assertOptionalString($code, 'Code must be string');
        $this->assertOptionalString($reason, 'Reason must be string');
        $this->assertOptionalString($providerResult, 'Provider result must be string');
        $this->assertOptionalString($providerCode, 'Provider code must be string');
        $this->assertOptionalString($providerReason, 'Provider reason must be string');
        $this->assertOptionalString($profileId, 'Profile id must be string');
        $this->assertOptionalString($profileType, 'Profile type must be string');
        $this->assertOptionalString($profileSubType, 'Profile sub type must be string');
        $this->assertOptionalString($industry, 'Industry must be string');
        $this->assertOptionalString($description, 'Description must be string');
        $this->assertOptionalInt($regDate, 'Reg date must be integer');
        $this->assertOptionalString($regNumber, 'Reg number must be string');
        $this->assertOptionalString($vatNumber, 'Vat number must be string');
        $this->assertOptionalString($secondCountry, 'Secondary country must be string');
        $this->assertOptionalString($secondState, 'Second state must be string');
        $this->assertOptionalString($secondCity, 'Second city must be string');
        $this->assertOptionalString($secondAddress, 'Second address must be string');
        $this->assertOptionalString($secondZip, 'Second zip must be string');
        $this->assertOptionalString($providerId, 'Provider id must be string');
        $this->assertOptionalString($contactEmail, 'Contact email must be string');
        $this->assertOptionalString($contactPhone, 'Contact phone must be string');
        $this->assertOptionalString($walletType, 'Wallet type must be string');
        $this->assertOptionalString($nationality, 'Nationality must be string');
        $this->assertOptionalBool($finalBeneficiary, 'Final beneficiary must be boolean');
        $this->assertOptionalString($employmentStatus, 'Employment status must be string');
        $this->assertOptionalString($sourceOfFunds, 'Source of funds must be string');
        $this->assertOptionalInt($issueDate, 'Issue date must be integer');
        $this->assertOptionalInt($expiryDate, 'Expiry date must be integer');
        $this->assertOptionalString($verificationMode, 'Verification mode must be string');
        $this->assertOptionalString($verificationSource, 'Verification source must be string');
        $this->assertOptionalBool($consent, 'Consent must be boolean');
        $this->assertOptionalBool($allowNaOcrInputs, 'Allow na ocr inputs must be boolean');
        $this->assertOptionalBool($declineOnSingleStep, 'Decline on single step must be boolean');
        $this->assertOptionalBool($backsideProof, 'Backside proof must be boolean');
        $this->assertOptionalString($kycLanguage, 'Kyc language must be string');
        $this->assertOptionalString($redirectUrl, 'Redirect url must be string');
        if ($numberOfDocuments !== null && !in_array($numberOfDocuments, [0, 1, 2])) {
            throw new \InvalidArgumentException('Incorrect value. Number Of Documents must contains 0, 1 or 2');
        }
        $this->assertOptionalString($allowedDocumentFormat, 'Allowed document format must be string');
        $this->assertOptionalBool($addressConfirmed, 'Address confirmed must be boolean');
        $this->assertOptionalBool($secondAddressConfirmed, 'Second address confirmed must be boolean');

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
        $this->replace('address_confirmed', $addressConfirmed);
        $this->replace('second_address_confirmed', $secondAddressConfirmed);

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
        $this->assertInt($kycStartId, 'Kyc start ID must be integer');

        $this->replace('kyc_start_id', $kycStartId);

        return $this;
    }

    /**
     * @param string $eventId
     * @param int $eventTimestamp
     * @param string|null $groupId
     * @param string|null $status
     * @param string|null $code
     * @param string|null $reason
     * @param string|null $providerId
     * @param string|null $providerResult
     * @param string|null $providerCode
     * @param string|null $providerReason
     * @param string|null $profileId
     * @param string|null $profileType
     * @param string|null $profileSubType
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $fullName
     * @param string|null $gender
     * @param string|null $industry
     * @param string|null $walletType
     * @param string|null $websiteUrl
     * @param string|null $description
     * @param string|null $employmentStatus
     * @param string|null $sourceOfFunds
     * @param int|null $birthDate
     * @param int|null $regDate
     * @param int|null $issueDate
     * @param int|null $expiryDate
     * @param string|null $regNumber
     * @param string|null $vatNumber
     * @param string|null $email
     * @param bool|null $emailConfirmed
     * @param string|null $phone
     * @param bool|null $phoneConfirmed
     * @param string|null $contactEmail
     * @param string|null $contactPhone
     * @param string|null $country
     * @param string|null $state
     * @param string|null $city
     * @param string|null $address
     * @param string|null $zip
     * @param string|null $nationality
     * @param string|null $secondCountry
     * @param string|null $secondState
     * @param string|null $secondCity
     * @param string|null $secondAddress
     * @param string|null $secondZip
     * @param bool|null $ajaxValidation
     * @param bool|null $cookieEnabled
     * @param string|null $cpuClass
     * @param string|null $deviceFingerprint
     * @param string|null $deviceId
     * @param bool|null $doNotTrack
     * @param string|null $ip
     * @param string|null $realIp
     * @param string|null $localIpList
     * @param string|null $language
     * @param string|null $languages
     * @param string|null $languageBrowser
     * @param string|null $languageUser
     * @param string|null $languageSystem
     * @param string|null $os
     * @param string|null $screenResolution
     * @param string|null $screenOrientation
     * @param string|null $clientResolution
     * @param int|null $timezoneOffset
     * @param string|null $userAgent
     * @param string|null $plugins
     * @param string|null $refererUrl
     * @param string|null $originUrl
     * @param bool|null $anonymous
     * @return $this
     */
    public function addKycSubmitData(
        $eventId,
        $eventTimestamp,
        $groupId = null,
        $status = null,
        $code = null,
        $reason = null,
        $providerId = null,
        $providerResult = null,
        $providerCode = null,
        $providerReason = null,
        $profileId = null,
        $profileType = null,
        $profileSubType = null,
        $firstName = null,
        $lastName = null,
        $fullName = null,
        $gender = null,
        $industry = null,
        $walletType = null,
        $websiteUrl = null,
        $description = null,
        $employmentStatus = null,
        $sourceOfFunds = null,
        $birthDate = null,
        $regDate = null,
        $issueDate = null,
        $expiryDate = null,
        $regNumber = null,
        $vatNumber = null,
        $email = null,
        $emailConfirmed = null,
        $phone = null,
        $phoneConfirmed = null,
        $contactEmail = null,
        $contactPhone = null,
        $country = null,
        $state = null,
        $city = null,
        $address = null,
        $zip = null,
        $nationality = null,
        $secondCountry = null,
        $secondState = null,
        $secondCity = null,
        $secondAddress = null,
        $secondZip = null,
        $ajaxValidation = null,
        $cookieEnabled = null,
        $cpuClass = null,
        $deviceFingerprint = null,
        $deviceId = null,
        $doNotTrack = null,
        $ip = null,
        $realIp = null,
        $localIpList = null,
        $language = null,
        $languages = null,
        $languageBrowser = null,
        $languageUser = null,
        $languageSystem = null,
        $os = null,
        $screenResolution = null,
        $screenOrientation = null,
        $clientResolution = null,
        $timezoneOffset = null,
        $userAgent = null,
        $plugins = null,
        $refererUrl = null,
        $originUrl = null,
        $addressConfirmed = null,
        $secondAddressConfirmed = null,
        $anonymous = null
    ) {
        $this->assertString($eventId, 'Event ID must be string');
        $this->assertInt($eventTimestamp, 'Event timestamp must be int');
        $this->assertOptionalString($groupId, 'Group id must be string');
        $this->assertOptionalString($status, 'Status must be string');
        $this->assertOptionalString($code, 'Code must be string');
        $this->assertOptionalString($reason, 'Reason must be string');
        $this->assertOptionalString($providerId, 'Provider id must be string');
        $this->assertOptionalString($providerResult, 'Provider result must be string');
        $this->assertOptionalString($providerCode, 'Provider code must be string');
        $this->assertOptionalString($providerReason, 'Provider reason must be string');
        $this->assertOptionalString($profileId, 'Profile Id must be string');
        $this->assertOptionalString($profileType, 'Profile Type must be string');
        $this->assertOptionalString($profileSubType, 'Profile Sub Type must be string');
        $this->assertOptionalString($firstName, 'Firstname must be string');
        $this->assertOptionalString($lastName, 'Lastname must be string');
        $this->assertOptionalString($fullName, 'Full Name must be string');
        $this->assertOptionalString($gender, 'Gender must be string');
        $this->assertOptionalString($industry, 'Industry must be string');
        $this->assertOptionalString($walletType, 'Wallet Type must be string');
        $this->assertOptionalString($websiteUrl, 'Website Url must be string');
        $this->assertOptionalString($description, 'Description must be string');
        $this->assertOptionalString($employmentStatus, 'Employment Status must be string');
        $this->assertOptionalString($sourceOfFunds, 'Source Of Funds must be string');
        $this->assertOptionalInt($birthDate, 'Birth Date must be int');
        $this->assertOptionalInt($regDate, 'Reg Date must be int');
        $this->assertOptionalInt($issueDate, 'Issue Date must be int');
        $this->assertOptionalInt($expiryDate, 'Expiry Date must be int');
        $this->assertOptionalString($regNumber, 'Reg Number must be string');
        $this->assertOptionalString($vatNumber, 'Vat Number must be string');
        $this->assertOptionalString($email, 'Email must be string');
        $this->assertOptionalBool($emailConfirmed, 'Email Confirmed flag must be boolean');
        $this->assertOptionalString($phone, 'Phone must be string');
        $this->assertOptionalBool($phoneConfirmed, 'Phone Confirmed flag must be boolean');
        $this->assertOptionalString($contactEmail, 'Contact Email must be string');
        $this->assertOptionalString($contactPhone, 'Contact Phone must be string');
        $this->assertOptionalString($country, 'Country must be string');
        $this->assertOptionalString($state, 'State must be string');
        $this->assertOptionalString($city, 'City must be string');
        $this->assertOptionalString($address, 'Address must be string');
        $this->assertOptionalString($zip, 'Zip must be string');
        $this->assertOptionalString($nationality, 'Nationality must be string');
        $this->assertOptionalString($secondCountry, 'Second Country must be string');
        $this->assertOptionalString($secondState, 'Second State must be string');
        $this->assertOptionalString($secondCity, 'Second City must be string');
        $this->assertOptionalString($secondAddress, 'Second Address must be string');
        $this->assertOptionalString($secondZip, 'Second Zip must be string');
        $this->assertOptionalBool($ajaxValidation, 'Ajax Validation must be boolean');
        $this->assertOptionalBool($cookieEnabled, 'Cookie Enabled must be boolean');
        $this->assertOptionalString($cpuClass, 'CPU Class must be string');
        $this->assertOptionalString($deviceFingerprint, 'Device Fingerprint must be string');
        $this->assertOptionalString($deviceId, 'Device Id must be string');
        $this->assertOptionalBool($doNotTrack, 'Do Not Track must be boolean');
        $this->assertOptionalBool($anonymous, 'Anonymous flag must be boolean');
        $this->assertOptionalString($ip, 'IP must be string');
        $this->assertOptionalString($realIp, 'Real IP must be string');
        $this->assertOptionalString($localIpList, 'Local IP List must be string');
        $this->assertOptionalString($language, 'Language must be string');
        $this->assertOptionalString($languages, 'Languages must be string');
        $this->assertOptionalString($languageBrowser, 'Language Browser must be string');
        $this->assertOptionalString($languageUser, 'Language User must be string');
        $this->assertOptionalString($languageSystem, 'Language System must be string');
        $this->assertOptionalString($os, 'OS must be string');
        $this->assertOptionalString($screenResolution, 'Screen Resolution must be string');
        $this->assertOptionalString($screenOrientation, 'Screen Orientation must be string');
        $this->assertOptionalString($clientResolution, 'Client Resolution must be string');
        $this->assertOptionalInt($timezoneOffset, 'Timezone Offset must be int');
        $this->assertOptionalString($userAgent, 'User Agent must be string');
        $this->assertOptionalString($plugins, 'Plugins must be string');
        $this->assertOptionalString($refererUrl, 'Referer Url must be string');
        $this->assertOptionalString($originUrl, 'Origin Url must be string');
        $this->assertOptionalBool($addressConfirmed, 'Address confirmed must be boolean');
        $this->assertOptionalBool($secondAddressConfirmed, 'Second address confirmed must be boolean');

        $this->replace('event_id', $eventId);
        $this->replace('event_timestamp', $eventTimestamp);
        $this->replace('group_id', $groupId);
        $this->replace('status', $status);
        $this->replace('code', $code);
        $this->replace('reason', $reason);
        $this->replace('provider_id', $providerId);
        $this->replace('provider_result', $providerResult);
        $this->replace('provider_code', $providerCode);
        $this->replace('provider_reason', $providerReason);
        $this->replace('profile_id', $profileId);
        $this->replace('profile_type', $profileType);
        $this->replace('profile_sub_type', $profileSubType);
        $this->replace('firstname', $firstName);
        $this->replace('lastname', $lastName);
        $this->replace('fullname', $fullName);
        $this->replace('gender', $gender);
        $this->replace('industry', $industry);
        $this->replace('wallet_type', $walletType);
        $this->replace('website_url', $websiteUrl);
        $this->replace('description', $description);
        $this->replace('employment_status', $employmentStatus);
        $this->replace('source_of_funds', $sourceOfFunds);
        $this->replace('birth_date', $birthDate);
        $this->replace('reg_date', $regDate);
        $this->replace('issue_date', $issueDate);
        $this->replace('expiry_date', $expiryDate);
        $this->replace('reg_number', $regNumber);
        $this->replace('vat_number', $vatNumber);
        $this->replace('email', $email);
        $this->replace('email_confirmed', $emailConfirmed);
        $this->replace('phone', $phone);
        $this->replace('phone_confirmed', $phoneConfirmed);
        $this->replace('contact_email', $contactEmail);
        $this->replace('contact_phone', $contactPhone);
        $this->replace('country', $country);
        $this->replace('state', $state);
        $this->replace('city', $city);
        $this->replace('address', $address);
        $this->replace('zip', $zip);
        $this->replace('nationality', $nationality);
        $this->replace('second_country', $secondCountry);
        $this->replace('second_state', $secondState);
        $this->replace('second_city', $secondCity);
        $this->replace('second_address', $secondAddress);
        $this->replace('second_zip', $secondZip);
        $this->replace('ajax_validation', $ajaxValidation);
        $this->replace('cookie_enabled', $cookieEnabled);
        $this->replace('cpu_class', $cpuClass);
        $this->replace('device_fingerprint', $deviceFingerprint);
        $this->replace('device_id', $deviceId);
        $this->replace('do_not_track', $doNotTrack);
        $this->replace('anonymous', $anonymous);
        $this->replace('ip', $ip);
        $this->replace('real_ip', $realIp);
        $this->replace('local_ip_list', $localIpList);
        $this->replace('language', $language);
        $this->replace('languages', $languages);
        $this->replace('language_browser', $languageBrowser);
        $this->replace('language_user', $languageUser);
        $this->replace('language_system', $languageSystem);
        $this->replace('os', $os);
        $this->replace('screen_resolution', $screenResolution);
        $this->replace('screen_orientation', $screenOrientation);
        $this->replace('client_resolution', $clientResolution);
        $this->replace('timezone_offset', $timezoneOffset);
        $this->replace('user_agent', $userAgent);
        $this->replace('plugins', $plugins);
        $this->replace('referer_url', $refererUrl);
        $this->replace('origin_url', $originUrl);
        $this->replace('address_confirmed', $addressConfirmed);
        $this->replace('second_address_confirmed', $secondAddressConfirmed);

        return $this;
    }
}
