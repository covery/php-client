<?php

namespace Covery\Client\Envelopes;

use Covery\Client\DocumentType;
use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

/**
 * Envelope builder methods split out of Builder to reduce its size.
 */
trait ProfileBuilder
{
    /**
     * @param $eventId
     * @param $eventTimestamp
     * @param $userMerchantId
     * @param string|null $sequenceId
     * @param string|null $groupId
     * @param string|null $operation
     * @param string|null $accountId
     * @param string|null $accountSystem
     * @param string|null $currency
     * @param string|null $phone
     * @param bool|null $phoneConfirmed
     * @param string|null $email
     * @param bool|null $emailConfirmed
     * @param string|null $contactEmail
     * @param string|null $contactPhone
     * @param bool|null $toFaAllowed
     * @param string|null $userName
     * @param string|null $password
     * @param string|null $socialType
     * @param string|null $gameLevel
     * @param string|null $firstname
     * @param string|null $lastname
     * @param string|null $fullName
     * @param int|null $birthDate
     * @param int|null $age
     * @param string|null $gender
     * @param string|null $maritalStatus
     * @param string|null $nationality
     * @param string|null $physique
     * @param float|null $height
     * @param float|null $weight
     * @param string|null $hair
     * @param string|null $eyes
     * @param string|null $education
     * @param string|null $employmentStatus
     * @param string|null $sourceOfFunds
     * @param string|null $industry
     * @param bool|null $finalBeneficiary
     * @param string|null $walletType
     * @param string|null $websiteUrl
     * @param string|null $description
     * @param string|null $country
     * @param string|null $state
     * @param string|null $city
     * @param string|null $zip
     * @param string|null $address
     * @param bool|null $addressConfirmed
     * @param string|null $secondCountry
     * @param string|null $secondState
     * @param string|null $secondCity
     * @param string|null $secondZip
     * @param string|null $secondAddress
     * @param bool|null $secondAddressConfirmed
     * @param string|null $profileId
     * @param string|null $profileType
     * @param string|null $profileSubType
     * @param string|null $documentCountry
     * @param bool|null $documentConfirmed
     * @param int|null $regDate
     * @param int|null $issueDate
     * @param int|null $expiryDate
     * @param string|null $regNumber
     * @param string|null $vatNumber
     * @param string|null $purposeToOpenAccount
     * @param float|null $oneOperationLimit
     * @param float|null $dailyLimit
     * @param float|null $weeklyLimit
     * @param float|null $monthlyLimit
     * @param float|null $annualLimit
     * @param string|null $activeFeatures
     * @param string|null $promotions
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
     * @param string|null $linksToDocuments
     * @param array|null $documentId
     * @param bool|null $anonymous
     * @return static
     */
    public static function profileUpdateEvent(
        $eventId,
        $eventTimestamp,
        $userMerchantId,
        $sequenceId = null,
        $groupId = null,
        $operation = null,
        $accountId = null,
        $accountSystem = null,
        $currency = null,
        $phone = null,
        $phoneConfirmed = null,
        $email = null,
        $emailConfirmed = null,
        $contactEmail = null,
        $contactPhone = null,
        $toFaAllowed = null,
        $userName = null,
        $password = null,
        $socialType = null,
        $gameLevel = null,
        $firstname = null,
        $lastname = null,
        $fullName = null,
        $birthDate = null,
        $age = null,
        $gender = null,
        $maritalStatus = null,
        $nationality = null,
        $physique = null,
        $height = null,
        $weight = null,
        $hair = null,
        $eyes = null,
        $education = null,
        $employmentStatus = null,
        $sourceOfFunds = null,
        $industry = null,
        $finalBeneficiary = null,
        $walletType = null,
        $websiteUrl = null,
        $description = null,
        $country = null,
        $state = null,
        $city =  null,
        $zip = null,
        $address = null,
        $addressConfirmed = null,
        $secondCountry = null,
        $secondState = null,
        $secondCity = null,
        $secondZip = null,
        $secondAddress = null,
        $secondAddressConfirmed = null,
        $profileId = null,
        $profileType = null,
        $profileSubType = null,
        $documentCountry = null,
        $documentConfirmed = null,
        $regDate = null,
        $issueDate = null,
        $expiryDate = null,
        $regNumber = null,
        $vatNumber = null,
        $purposeToOpenAccount = null,
        $oneOperationLimit = null,
        $dailyLimit = null,
        $weeklyLimit = null,
        $monthlyLimit = null,
        $annualLimit = null,
        $activeFeatures = null,
        $promotions = null,
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
        $linksToDocuments = null,
        $documentId = null,
        $anonymous = null
    ) {
        $builder = new Builder(Builder::EVENT_PROFILE_UPDATE, $sequenceId);

        return $builder
            ->addProfileData(
                $eventId,
                $eventTimestamp,
                $userMerchantId,
                $groupId,
                $operation,
                $accountId,
                $accountSystem,
                $currency,
                $phone,
                $phoneConfirmed,
                $email,
                $emailConfirmed,
                $contactEmail,
                $contactPhone,
                $toFaAllowed,
                $userName,
                $password,
                $socialType,
                $gameLevel,
                $firstname,
                $lastname,
                $fullName,
                $birthDate,
                $age,
                $gender,
                $maritalStatus,
                $nationality,
                $physique,
                $height,
                $weight,
                $hair,
                $eyes,
                $education,
                $employmentStatus,
                $sourceOfFunds,
                $industry,
                $finalBeneficiary,
                $walletType,
                $websiteUrl,
                $description,
                $country,
                $state,
                $city,
                $zip,
                $address,
                $addressConfirmed,
                $secondCountry,
                $secondState,
                $secondCity,
                $secondZip,
                $secondAddress,
                $secondAddressConfirmed,
                $profileId,
                $profileType,
                $profileSubType,
                $documentCountry,
                $documentConfirmed,
                $regDate,
                $issueDate,
                $expiryDate,
                $regNumber,
                $vatNumber,
                $purposeToOpenAccount,
                $oneOperationLimit,
                $dailyLimit,
                $weeklyLimit,
                $monthlyLimit,
                $annualLimit,
                $activeFeatures,
                $promotions,
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
                $anonymous
            )
            ->addLinksToDocuments($linksToDocuments)
            ->addDocumentData($documentId);

    }

    public function addProfileData(
        $eventId,
        $eventTimestamp,
        $userMerchantId,
        $groupId = null,
        $operation = null,
        $accountId = null,
        $accountSystem = null,
        $currency = null,
        $phone = null,
        $phoneConfirmed = null,
        $email = null,
        $emailConfirmed = null,
        $contactEmail = null,
        $contactPhone = null,
        $toFaAllowed = null,
        $username = null,
        $password = null,
        $socialType = null,
        $gameLevel = null,
        $firstname = null,
        $lastname = null,
        $fullName = null,
        $birthDate = null,
        $age = null,
        $gender = null,
        $maritalStatus = null,
        $nationality = null,
        $physique = null,
        $height = null,
        $weight = null,
        $hair = null,
        $eyes = null,
        $education = null,
        $employmentStatus = null,
        $sourceOfFunds = null,
        $industry = null,
        $finalBeneficiary = null,
        $walletType = null,
        $websiteUrl = null,
        $description = null,
        $country = null,
        $state = null,
        $city =  null,
        $zip = null,
        $address = null,
        $addressConfirmed = null,
        $secondCountry = null,
        $secondState = null,
        $secondCity = null,
        $secondZip = null,
        $secondAddress = null,
        $secondAddressConfirmed = null,
        $profileId = null,
        $profileType = null,
        $profileSubType = null,
        $documentCountry = null,
        $documentConfirmed = null,
        $regDate = null,
        $issueDate = null,
        $expiryDate = null,
        $regNumber = null,
        $vatNumber = null,
        $purposeToOpenAccount = null,
        $oneOperationLimit = null,
        $dailyLimit = null,
        $weeklyLimit = null,
        $monthlyLimit = null,
        $annualLimit = null,
        $activeFeatures = null,
        $promotions = null,
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
        $anonymous = null
    ) {
        $this->assertString($eventId, 'Event ID must be string');

        $this->assertInt($eventTimestamp, 'Event Timestamp must be int');

        $this->assertString($userMerchantId, 'User Merchant ID must be string');

        $this->assertOptionalString($groupId, 'Group Id must be string');

        $this->assertOptionalString($operation, 'Operation must be string');

        $this->assertOptionalString($accountId, 'Account Id must be string');

        $this->assertOptionalString($accountSystem, 'Account System must be string');

        $this->assertOptionalString($currency, 'Currency must be string');

        $this->assertOptionalString($phone, 'Phone must be string');

        $this->assertOptionalBool($phoneConfirmed, 'Phone Confirmed flag must be boolean');

        $this->assertOptionalString($email, 'Email must be string');

        $this->assertOptionalBool($emailConfirmed, 'Email Confirmed flag must be boolean');

        $this->assertOptionalString($contactEmail, 'Contact Email must be string');

        $this->assertOptionalString($contactPhone, 'Contact Phone must be string');

        $this->assertOptionalBool($toFaAllowed, '2faAllowed flag must be boolean');

        $this->assertOptionalString($username, 'Username must be string');

        $this->assertOptionalString($password, 'Password must be string');

        $this->assertOptionalString($socialType, 'Social Type must be string');

        $this->assertOptionalString($gameLevel, 'Game Level must be string');

        $this->assertOptionalString($firstname, 'Firstname must be string');

        $this->assertOptionalString($lastname, 'Lastname must be string');

        $this->assertOptionalString($fullName, 'Full Name must be string');

        $this->assertOptionalInt($birthDate, 'Birth Date must be int');

        $this->assertOptionalInt($age, 'Age must be int');

        $this->assertOptionalString($gender, 'Gender must be string');

        $this->assertOptionalString($maritalStatus, 'Marital Status must be string');

        $this->assertOptionalString($nationality, 'Nationality must be string');

        $this->assertOptionalString($physique, 'Physique must be string');

        $this->assertOptionalFloat($height, 'Height must be float');

        $this->assertOptionalFloat($weight, 'Weight must be float');

        $this->assertOptionalString($hair, 'Hair must be string');

        $this->assertOptionalString($eyes, 'Eyes must be string');

        $this->assertOptionalString($education, 'Education must be string');

        $this->assertOptionalString($employmentStatus, 'Employment Status must be string');

        $this->assertOptionalString($sourceOfFunds, 'Source Of Funds must be string');

        $this->assertOptionalString($industry, 'Industry must be string');

        $this->assertOptionalBool($finalBeneficiary, 'Final Beneficiary must be boolean');

        $this->assertOptionalString($walletType, 'Wallet Type must be string');

        $this->assertOptionalString($websiteUrl, 'Website Url must be string');

        $this->assertOptionalString($description, 'Description must be string');

        $this->assertOptionalString($country, 'Country must be string');

        $this->assertOptionalString($state, 'State must be string');

        $this->assertOptionalString($city, 'City must be string');

        $this->assertOptionalString($zip, 'Zip must be string');

        $this->assertOptionalString($address, 'Address must be string');

        $this->assertOptionalBool($addressConfirmed, 'Address Confirmed must be boolean');

        $this->assertOptionalString($secondCountry, 'Second Country must be string');

        $this->assertOptionalString($secondState, 'Second State must be string');

        $this->assertOptionalString($secondCity, 'Second City must be string');

        $this->assertOptionalString($secondZip, 'Second Zip must be string');

        $this->assertOptionalString($secondAddress, 'Second Address must be string');

        $this->assertOptionalBool($secondAddressConfirmed, 'Second Address Confirmed must be boolean');

        $this->assertOptionalString($profileId, 'Profile Id must be string');

        $this->assertOptionalString($profileType, 'Profile Type must be string');

        $this->assertOptionalString($profileSubType, 'Profile Sub Type must be string');

        $this->assertOptionalString($documentCountry, 'Document Country must be string');

        $this->assertOptionalBool($documentConfirmed, 'Document Confirmed must be boolean');

        $this->assertOptionalInt($regDate, 'Reg Date must be int');

        $this->assertOptionalInt($issueDate, 'Issue Date must be int');

        $this->assertOptionalInt($expiryDate, 'Expiry Date must be int');

        $this->assertOptionalString($regNumber, 'Reg Number must be string');

        $this->assertOptionalString($vatNumber, 'Vat Number must be string');

        $this->assertOptionalString($purposeToOpenAccount, 'Purpose To Open Account must be string');

        if ($oneOperationLimit !== null) {
            $this->assertFloat($oneOperationLimit, 'One Operation Limit must be float');
            if ($oneOperationLimit < 0) {
                throw new \InvalidArgumentException('One Operation Limit cannot be negative');
            }
        }

        if ($dailyLimit !== null) {
            $this->assertFloat($dailyLimit, 'Daily Limit must be float');
            if ($dailyLimit < 0) {
                throw new \InvalidArgumentException('Daily Limit cannot be negative');
            }
        }

        if ($weeklyLimit !== null) {
            $this->assertFloat($weeklyLimit, 'Weekly Limit must be float');
            if ($weeklyLimit < 0) {
                throw new \InvalidArgumentException('Weekly Limit cannot be negative');
            }
        }

        if ($monthlyLimit !== null) {
            $this->assertFloat($monthlyLimit, 'Monthly Limit must be float');
            if ($monthlyLimit < 0) {
                throw new \InvalidArgumentException('Monthly Limit cannot be negative');
            }
        }

        if ($annualLimit !== null) {
            $this->assertFloat($annualLimit, 'Annual Limit must be float');
            if ($annualLimit < 0) {
                throw new \InvalidArgumentException('Annual Limit cannot be negative');
            }
        }

        $this->assertOptionalString($activeFeatures, 'Active Features must be string');

        $this->assertOptionalString($promotions, 'Promotions must be string');

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

        $this->replace('event_id', $eventId);
        $this->replace('event_timestamp', $eventTimestamp);
        $this->replace('user_merchant_id', $userMerchantId);
        $this->replace('group_id', $groupId);
        $this->replace('operation', $operation);
        $this->replace('account_id', $accountId);
        $this->replace('account_system', $accountSystem);
        $this->replace('currency', $currency);
        $this->replace('phone', $phone);
        $this->replace('phone_confirmed', $phoneConfirmed);
        $this->replace('email', $email);
        $this->replace('email_confirmed', $emailConfirmed);
        $this->replace('contact_email', $contactEmail);
        $this->replace('contact_phone', $contactPhone);
        $this->replace('2fa_allowed', $toFaAllowed);
        $this->replace('user_name', $username);
        $this->replace('password', $password);
        $this->replace('social_type', $socialType);
        $this->replace('game_level', $gameLevel);
        $this->replace('firstname', $firstname);
        $this->replace('lastname', $lastname);
        $this->replace('fullname', $fullName);
        $this->replace('birth_date', $birthDate);
        $this->replace('age', $age);
        $this->replace('gender', $gender);
        $this->replace('marital_status', $maritalStatus);
        $this->replace('nationality', $nationality);
        $this->replace('physique', $physique);
        $this->replace('height', $height);
        $this->replace('weight', $weight);
        $this->replace('hair', $hair);
        $this->replace('eyes', $eyes);
        $this->replace('education', $education);
        $this->replace('employment_status', $employmentStatus);
        $this->replace('source_of_funds', $sourceOfFunds);
        $this->replace('industry', $industry);
        $this->replace('final_beneficiary', $finalBeneficiary);
        $this->replace('wallet_type', $walletType);
        $this->replace('website_url', $websiteUrl);
        $this->replace('description', $description);
        $this->replace('country', $country);
        $this->replace('state', $state);
        $this->replace('city', $city);
        $this->replace('zip', $zip);
        $this->replace('address', $address);
        $this->replace('address_confirmed', $addressConfirmed);
        $this->replace('second_country', $secondCountry);
        $this->replace('second_state', $secondState);
        $this->replace('second_city', $secondCity);
        $this->replace('second_zip', $secondZip);
        $this->replace('second_address', $secondAddress);
        $this->replace('second_address_confirmed', $secondAddressConfirmed);
        $this->replace('profile_id', $profileId);
        $this->replace('profile_type', $profileType);
        $this->replace('profile_sub_type', $profileSubType);
        $this->replace('document_country', $documentCountry);
        $this->replace('document_confirmed', $documentConfirmed);
        $this->replace('reg_date', $regDate);
        $this->replace('issue_date', $issueDate);
        $this->replace('expiry_date', $expiryDate);
        $this->replace('reg_number', $regNumber);
        $this->replace('vat_number', $vatNumber);
        $this->replace('purpose_to_open_account', $purposeToOpenAccount);
        $this->replaceZeroAllowed('one_operation_limit', $oneOperationLimit);
        $this->replaceZeroAllowed('daily_limit', $dailyLimit);
        $this->replaceZeroAllowed('weekly_limit', $weeklyLimit);
        $this->replaceZeroAllowed('monthly_limit', $monthlyLimit);
        $this->replaceZeroAllowed('annual_limit', $annualLimit);
        $this->replace('active_features', $activeFeatures);
        $this->replace('promotions', $promotions);
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

        return $this;
    }
}
