<?php

namespace Covery\Client\IndividualProfile;

class Builder
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * When true (PUT/update) every field is sent - null included - so the
     * server overwrites omitted fields with NULL. When false (POST/create)
     * null/empty/zero values are dropped from the payload.
     *
     * @var bool
     */
    private $sendNulls = false;

    /**
     * Returns builder for individual profile creation (POST).
     * Requires sequence_id.
     *
     * @param string $sequenceId Mandatory for POST
     * @param string|null $userMerchantId
     * @param string|null $accountStatus
     * @param int|null $regDate
     * @param string|null $phone
     * @param bool|null $phoneConfirmed
     * @param string|null $email
     * @param bool|null $emailConfirmed
     * @param string|null $userName
     * @param string|null $password
     * @param string|null $fullname
     * @param bool|null $hasMiddleName
     * @param int|null $birthDate
     * @param string|null $gender
     * @param string|null $maritalStatus
     * @param string|null $nationality
     * @param string|null $education
     * @param string|null $employmentStatus
     * @param string|null $sourceOfFunds
     * @param string|null $documentCountry
     * @param bool|null $documentConfirmed
     * @param string|null $regNumber
     * @param int|null $issueDate
     * @param int|null $expiryDate
     * @param string|null $vatNumber
     * @param bool|null $vatConfirmed
     * @param bool|null $declarationOfTrust
     * @param string|null $description
     * @param string|null $country
     * @param string|null $state
     * @param string|null $city
     * @param string|null $zip
     * @param string|null $address
     * @param bool|null $addressConfirmed
     * @param string|null $purposeToOpenAccount
     * @param float|null $oneOperationLimit
     * @param float|null $dailyLimit
     * @param float|null $weeklyLimit
     * @param float|null $monthlyLimit
     * @param float|null $annualLimit
     * @param string[]|null $activeFeatures
     * @param string[]|null $promotions
     * @return Builder
     */
    public static function createIndividualProfileEvent(
        $sequenceId,
        $userMerchantId = null,
        $accountStatus = null,
        $regDate = null,
        $phone = null,
        $phoneConfirmed = null,
        $email = null,
        $emailConfirmed = null,
        $userName = null,
        $password = null,
        $fullname = null,
        $hasMiddleName = null,
        $birthDate = null,
        $gender = null,
        $maritalStatus = null,
        $nationality = null,
        $education = null,
        $employmentStatus = null,
        $sourceOfFunds = null,
        $documentCountry = null,
        $documentConfirmed = null,
        $regNumber = null,
        $issueDate = null,
        $expiryDate = null,
        $vatNumber = null,
        $vatConfirmed = null,
        $declarationOfTrust = null,
        $description = null,
        $country = null,
        $state = null,
        $city = null,
        $zip = null,
        $address = null,
        $addressConfirmed = null,
        $purposeToOpenAccount = null,
        $oneOperationLimit = null,
        $dailyLimit = null,
        $weeklyLimit = null,
        $monthlyLimit = null,
        $annualLimit = null,
        $activeFeatures = null,
        $promotions = null
    ) {
        if (!is_string($sequenceId) || $sequenceId === '') {
            throw new \InvalidArgumentException('Sequence id must be non-empty string');
        }
        if (strlen($sequenceId) > 255) {
            throw new \InvalidArgumentException('Sequence id is too long');
        }

        $builder = new self();
        $builder->data['sequence_id'] = $sequenceId;

        return $builder->addProfileData(
            $userMerchantId,
            $accountStatus,
            $regDate,
            $phone,
            $phoneConfirmed,
            $email,
            $emailConfirmed,
            $userName,
            $password,
            $fullname,
            $hasMiddleName,
            $birthDate,
            $gender,
            $maritalStatus,
            $nationality,
            $education,
            $employmentStatus,
            $sourceOfFunds,
            $documentCountry,
            $documentConfirmed,
            $regNumber,
            $issueDate,
            $expiryDate,
            $vatNumber,
            $vatConfirmed,
            $declarationOfTrust,
            $description,
            $country,
            $state,
            $city,
            $zip,
            $address,
            $addressConfirmed,
            $purposeToOpenAccount,
            $oneOperationLimit,
            $dailyLimit,
            $weeklyLimit,
            $monthlyLimit,
            $annualLimit,
            $activeFeatures,
            $promotions
        );
    }

    /**
     * Returns builder for individual profile update (PUT).
     * Requires client_profile_id.
     *
     * @param int $clientProfileId Mandatory for PUT — internal Covery profile id
     * @param string|null $userMerchantId
     * @param string|null $accountStatus
     * @param int|null $regDate
     * @param string|null $phone
     * @param bool|null $phoneConfirmed
     * @param string|null $email
     * @param bool|null $emailConfirmed
     * @param string|null $userName
     * @param string|null $password
     * @param string|null $fullname
     * @param bool|null $hasMiddleName
     * @param int|null $birthDate
     * @param string|null $gender
     * @param string|null $maritalStatus
     * @param string|null $nationality
     * @param string|null $education
     * @param string|null $employmentStatus
     * @param string|null $sourceOfFunds
     * @param string|null $documentCountry
     * @param bool|null $documentConfirmed
     * @param string|null $regNumber
     * @param int|null $issueDate
     * @param int|null $expiryDate
     * @param string|null $vatNumber
     * @param bool|null $vatConfirmed
     * @param bool|null $declarationOfTrust
     * @param string|null $description
     * @param string|null $country
     * @param string|null $state
     * @param string|null $city
     * @param string|null $zip
     * @param string|null $address
     * @param bool|null $addressConfirmed
     * @param string|null $purposeToOpenAccount
     * @param float|null $oneOperationLimit
     * @param float|null $dailyLimit
     * @param float|null $weeklyLimit
     * @param float|null $monthlyLimit
     * @param float|null $annualLimit
     * @param string[]|null $activeFeatures
     * @param string[]|null $promotions
     * @return Builder
     */
    public static function updateIndividualProfileEvent(
        $clientProfileId,
        $userMerchantId = null,
        $accountStatus = null,
        $regDate = null,
        $phone = null,
        $phoneConfirmed = null,
        $email = null,
        $emailConfirmed = null,
        $userName = null,
        $password = null,
        $fullname = null,
        $hasMiddleName = null,
        $birthDate = null,
        $gender = null,
        $maritalStatus = null,
        $nationality = null,
        $education = null,
        $employmentStatus = null,
        $sourceOfFunds = null,
        $documentCountry = null,
        $documentConfirmed = null,
        $regNumber = null,
        $issueDate = null,
        $expiryDate = null,
        $vatNumber = null,
        $vatConfirmed = null,
        $declarationOfTrust = null,
        $description = null,
        $country = null,
        $state = null,
        $city = null,
        $zip = null,
        $address = null,
        $addressConfirmed = null,
        $purposeToOpenAccount = null,
        $oneOperationLimit = null,
        $dailyLimit = null,
        $weeklyLimit = null,
        $monthlyLimit = null,
        $annualLimit = null,
        $activeFeatures = null,
        $promotions = null
    ) {
        if (!is_int($clientProfileId)) {
            throw new \InvalidArgumentException('Client profile id must be integer');
        }
        if ($clientProfileId <= 0) {
            throw new \InvalidArgumentException('Client profile id must be positive integer');
        }

        $builder = new self();
        $builder->sendNulls = true;
        $builder->data['client_profile_id'] = $clientProfileId;

        return $builder->addProfileData(
            $userMerchantId,
            $accountStatus,
            $regDate,
            $phone,
            $phoneConfirmed,
            $email,
            $emailConfirmed,
            $userName,
            $password,
            $fullname,
            $hasMiddleName,
            $birthDate,
            $gender,
            $maritalStatus,
            $nationality,
            $education,
            $employmentStatus,
            $sourceOfFunds,
            $documentCountry,
            $documentConfirmed,
            $regNumber,
            $issueDate,
            $expiryDate,
            $vatNumber,
            $vatConfirmed,
            $declarationOfTrust,
            $description,
            $country,
            $state,
            $city,
            $zip,
            $address,
            $addressConfirmed,
            $purposeToOpenAccount,
            $oneOperationLimit,
            $dailyLimit,
            $weeklyLimit,
            $monthlyLimit,
            $annualLimit,
            $activeFeatures,
            $promotions
        );
    }

    /**
     * Provides individual profile fields to the packet.
     *
     * @return Builder
     */
    public function addProfileData(
        $userMerchantId = null,
        $accountStatus = null,
        $regDate = null,
        $phone = null,
        $phoneConfirmed = null,
        $email = null,
        $emailConfirmed = null,
        $userName = null,
        $password = null,
        $fullname = null,
        $hasMiddleName = null,
        $birthDate = null,
        $gender = null,
        $maritalStatus = null,
        $nationality = null,
        $education = null,
        $employmentStatus = null,
        $sourceOfFunds = null,
        $documentCountry = null,
        $documentConfirmed = null,
        $regNumber = null,
        $issueDate = null,
        $expiryDate = null,
        $vatNumber = null,
        $vatConfirmed = null,
        $declarationOfTrust = null,
        $description = null,
        $country = null,
        $state = null,
        $city = null,
        $zip = null,
        $address = null,
        $addressConfirmed = null,
        $purposeToOpenAccount = null,
        $oneOperationLimit = null,
        $dailyLimit = null,
        $weeklyLimit = null,
        $monthlyLimit = null,
        $annualLimit = null,
        $activeFeatures = null,
        $promotions = null
    ) {
        $this->assertString('user_merchant_id', $userMerchantId, 255);
        $this->assertString('account_status', $accountStatus, 255);
        $this->assertInt('reg_date', $regDate);
        $this->assertString('phone', $phone, 255);
        $this->assertBool('phone_confirmed', $phoneConfirmed);
        $this->assertString('email', $email, 255);
        $this->assertBool('email_confirmed', $emailConfirmed);
        $this->assertString('user_name', $userName, 255);
        $this->assertString('password', $password, 255);
        $this->assertString('fullname', $fullname, 255);
        $this->assertBool('has_middle_name', $hasMiddleName);
        $this->assertInt('birth_date', $birthDate);
        $this->assertString('gender', $gender, 255);
        $this->assertString('marital_status', $maritalStatus, 255);
        $this->assertString('nationality', $nationality, 255);
        $this->assertString('education', $education, 255);
        $this->assertString('employment_status', $employmentStatus, 255);
        $this->assertString('source_of_funds', $sourceOfFunds, 255);
        $this->assertString('document_country', $documentCountry, 255);
        $this->assertBool('document_confirmed', $documentConfirmed);
        $this->assertString('reg_number', $regNumber, 255);
        $this->assertInt('issue_date', $issueDate);
        $this->assertInt('expiry_date', $expiryDate);
        $this->assertString('vat_number', $vatNumber, 255);
        $this->assertBool('vat_confirmed', $vatConfirmed);
        $this->assertBool('declaration_of_trust', $declarationOfTrust);
        $this->assertString('description', $description, 1024);
        $this->assertString('country', $country, 255);
        $this->assertString('state', $state, 255);
        $this->assertString('city', $city, 255);
        $this->assertString('zip', $zip, 255);
        $this->assertString('address', $address, 255);
        $this->assertBool('address_confirmed', $addressConfirmed);
        $this->assertString('purpose_to_open_account', $purposeToOpenAccount, 255);
        $this->assertFloat('one_operation_limit', $oneOperationLimit);
        $this->assertFloat('daily_limit', $dailyLimit);
        $this->assertFloat('weekly_limit', $weeklyLimit);
        $this->assertFloat('monthly_limit', $monthlyLimit);
        $this->assertFloat('annual_limit', $annualLimit);
        $this->assertStringList('active_features', $activeFeatures, 100, 255);
        $this->assertStringList('promotions', $promotions, 100, 255);

        return $this;
    }

    /**
     * Returns built IndividualProfile
     *
     * @return IndividualProfile
     */
    public function build()
    {
        if ($this->sendNulls) {
            return new IndividualProfile($this->data);
        }

        return new IndividualProfile(
            array_filter($this->data, function ($data) {
                return $data !== null;
            })
        );
    }

    /**
     * Stores a field value according to the builder mode.
     *
     * In create (POST) mode null/empty/zero values are dropped. In update
     * (PUT) mode every value is kept - including null - so the server
     * replaces the stored field with NULL ("PUT replaces all data").
     *
     * @param string $key
     * @param mixed $value
     */
    private function store($key, $value)
    {
        if ($this->sendNulls) {
            $this->data[$key] = $value;

            return;
        }

        if ($value === null || $value === '' || $value === 0 || $value === 0.0 || $value === []) {
            return;
        }

        $this->data[$key] = $value;
    }

    private function assertString($key, $value, $maxLength)
    {
        if ($value !== null) {
            if (!is_string($value)) {
                throw new \InvalidArgumentException(sprintf('Field "%s" must be string', $key));
            }
            if (strlen($value) > $maxLength) {
                throw new \InvalidArgumentException(sprintf('Field "%s" is too long, max %d bytes allowed', $key, $maxLength));
            }
        }

        $this->store($key, $value);
    }

    private function assertInt($key, $value)
    {
        if ($value !== null && !is_int($value)) {
            throw new \InvalidArgumentException(sprintf('Field "%s" must be integer', $key));
        }

        $this->store($key, $value);
    }

    private function assertBool($key, $value)
    {
        if ($value !== null && !is_bool($value)) {
            throw new \InvalidArgumentException(sprintf('Field "%s" must be boolean', $key));
        }

        $this->store($key, $value);
    }

    private function assertFloat($key, $value)
    {
        if ($value !== null && !is_int($value) && !is_float($value)) {
            throw new \InvalidArgumentException(sprintf('Field "%s" must be float', $key));
        }

        $this->store($key, $value);
    }

    private function assertStringList($key, $value, $maxElements, $maxElementLength)
    {
        if ($value !== null) {
            if (!is_array($value)) {
                throw new \InvalidArgumentException(sprintf('Field "%s" must be array', $key));
            }
            if (count($value) > $maxElements) {
                throw new \InvalidArgumentException(sprintf('Field "%s" must contain at most %d elements', $key, $maxElements));
            }
            foreach ($value as $element) {
                if (!is_string($element)) {
                    throw new \InvalidArgumentException(sprintf('Field "%s" must be list of string', $key));
                }
                if (strlen($element) > $maxElementLength) {
                    throw new \InvalidArgumentException(sprintf('Field "%s" element is too long, max %d bytes allowed', $key, $maxElementLength));
                }
            }
        }

        $this->store($key, $value);
    }
}
