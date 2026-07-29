<?php

namespace Covery\Client;

/**
 * Class ClientProfileResult
 *
 * Contains client profile result data, received from Covery
 *
 * @package Covery\Client
 */
class ClientProfileResult implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $clientProfileId;

    /**
     * @var string|null
     */
    private $sequenceId;

    /**
     * @var string|null
     */
    private $userMerchantId;

    /**
     * @var string|null
     */
    private $accountStatus;

    /**
     * @var int|null
     */
    private $regDate;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var bool|null
     */
    private $phoneConfirmed;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var bool|null
     */
    private $emailConfirmed;

    /**
     * @var string|null
     */
    private $userName;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var string|null
     */
    private $companyName;

    /**
     * @var string|null
     */
    private $websiteUrl;

    /**
     * @var string|null
     */
    private $industry;

    /**
     * @var string|null
     */
    private $fullname;

    /**
     * @var bool|null
     */
    private $hasMiddleName;

    /**
     * @var int|null
     */
    private $birthDate;

    /**
     * @var string|null
     */
    private $gender;

    /**
     * @var string|null
     */
    private $maritalStatus;

    /**
     * @var string|null
     */
    private $nationality;

    /**
     * @var string|null
     */
    private $education;

    /**
     * @var string|null
     */
    private $employmentStatus;

    /**
     * @var string|null
     */
    private $sourceOfFunds;

    /**
     * @var string|null
     */
    private $documentCountry;

    /**
     * @var bool|null
     */
    private $documentConfirmed;

    /**
     * @var string|null
     */
    private $regNumber;

    /**
     * @var int|null
     */
    private $issueDate;

    /**
     * @var int|null
     */
    private $expiryDate;

    /**
     * @var string|null
     */
    private $vatNumber;

    /**
     * @var bool|null
     */
    private $vatConfirmed;

    /**
     * @var bool|null
     */
    private $declarationOfTrust;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var string|null
     */
    private $state;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $zip;

    /**
     * @var string|null
     */
    private $address;

    /**
     * @var bool|null
     */
    private $addressConfirmed;

    /**
     * @var string|null
     */
    private $purposeToOpenAccount;

    /**
     * @var float|null
     */
    private $oneOperationLimit;

    /**
     * @var float|null
     */
    private $dailyLimit;

    /**
     * @var float|null
     */
    private $weeklyLimit;

    /**
     * @var float|null
     */
    private $monthlyLimit;

    /**
     * @var float|null
     */
    private $annualLimit;

    /**
     * @var array|null
     */
    private $activeFeatures;

    /**
     * @var array|null
     */
    private $promotions;

    /**
     * ClientProfileResult constructor.
     */
    public function __construct(
        $clientProfileId,
        $sequenceId,
        $userMerchantId,
        $accountStatus,
        $regDate,
        $phone,
        $phoneConfirmed,
        $email,
        $emailConfirmed,
        $userName,
        $password,
        $companyName,
        $websiteUrl,
        $industry,
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
    ) {
        if (!empty($clientProfileId) && !is_int($clientProfileId)) {
            throw new \InvalidArgumentException('ClientProfileId must be int');
        }
        if (!empty($sequenceId) && !is_string($sequenceId)) {
            throw new \InvalidArgumentException('SequenceId must be string');
        }
        if (!empty($userMerchantId) && !is_string($userMerchantId)) {
            throw new \InvalidArgumentException('UserMerchantId must be string');
        }
        if (!empty($accountStatus) && !is_string($accountStatus)) {
            throw new \InvalidArgumentException('AccountStatus must be string');
        }
        if (!empty($regDate) && !is_int($regDate)) {
            throw new \InvalidArgumentException('RegDate must be int');
        }
        if (!empty($phone) && !is_string($phone)) {
            throw new \InvalidArgumentException('Phone must be string');
        }
        if (!empty($phoneConfirmed) && !is_bool($phoneConfirmed)) {
            throw new \InvalidArgumentException('PhoneConfirmed must be bool');
        }
        if (!empty($email) && !is_string($email)) {
            throw new \InvalidArgumentException('Email must be string');
        }
        if (!empty($emailConfirmed) && !is_bool($emailConfirmed)) {
            throw new \InvalidArgumentException('EmailConfirmed must be bool');
        }
        if (!empty($userName) && !is_string($userName)) {
            throw new \InvalidArgumentException('UserName must be string');
        }
        if (!empty($password) && !is_string($password)) {
            throw new \InvalidArgumentException('Password must be string');
        }
        if (!empty($companyName) && !is_string($companyName)) {
            throw new \InvalidArgumentException('CompanyName must be string');
        }
        if (!empty($websiteUrl) && !is_string($websiteUrl)) {
            throw new \InvalidArgumentException('WebsiteUrl must be string');
        }
        if (!empty($industry) && !is_string($industry)) {
            throw new \InvalidArgumentException('Industry must be string');
        }
        if (!empty($fullname) && !is_string($fullname)) {
            throw new \InvalidArgumentException('Fullname must be string');
        }
        if (!empty($hasMiddleName) && !is_bool($hasMiddleName)) {
            throw new \InvalidArgumentException('HasMiddleName must be bool');
        }
        if (!empty($birthDate) && !is_int($birthDate)) {
            throw new \InvalidArgumentException('BirthDate must be int');
        }
        if (!empty($gender) && !is_string($gender)) {
            throw new \InvalidArgumentException('Gender must be string');
        }
        if (!empty($maritalStatus) && !is_string($maritalStatus)) {
            throw new \InvalidArgumentException('MaritalStatus must be string');
        }
        if (!empty($nationality) && !is_string($nationality)) {
            throw new \InvalidArgumentException('Nationality must be string');
        }
        if (!empty($education) && !is_string($education)) {
            throw new \InvalidArgumentException('Education must be string');
        }
        if (!empty($employmentStatus) && !is_string($employmentStatus)) {
            throw new \InvalidArgumentException('EmploymentStatus must be string');
        }
        if (!empty($sourceOfFunds) && !is_string($sourceOfFunds)) {
            throw new \InvalidArgumentException('SourceOfFunds must be string');
        }
        if (!empty($documentCountry) && !is_string($documentCountry)) {
            throw new \InvalidArgumentException('DocumentCountry must be string');
        }
        if (!empty($documentConfirmed) && !is_bool($documentConfirmed)) {
            throw new \InvalidArgumentException('DocumentConfirmed must be bool');
        }
        if (!empty($regNumber) && !is_string($regNumber)) {
            throw new \InvalidArgumentException('RegNumber must be string');
        }
        if (!empty($issueDate) && !is_int($issueDate)) {
            throw new \InvalidArgumentException('IssueDate must be int');
        }
        if (!empty($expiryDate) && !is_int($expiryDate)) {
            throw new \InvalidArgumentException('ExpiryDate must be int');
        }
        if (!empty($vatNumber) && !is_string($vatNumber)) {
            throw new \InvalidArgumentException('VatNumber must be string');
        }
        if (!empty($vatConfirmed) && !is_bool($vatConfirmed)) {
            throw new \InvalidArgumentException('VatConfirmed must be bool');
        }
        if (!empty($declarationOfTrust) && !is_bool($declarationOfTrust)) {
            throw new \InvalidArgumentException('DeclarationOfTrust must be bool');
        }
        if (!empty($description) && !is_string($description)) {
            throw new \InvalidArgumentException('Description must be string');
        }
        if (!empty($country) && !is_string($country)) {
            throw new \InvalidArgumentException('Country must be string');
        }
        if (!empty($state) && !is_string($state)) {
            throw new \InvalidArgumentException('State must be string');
        }
        if (!empty($city) && !is_string($city)) {
            throw new \InvalidArgumentException('City must be string');
        }
        if (!empty($zip) && !is_string($zip)) {
            throw new \InvalidArgumentException('Zip must be string');
        }
        if (!empty($address) && !is_string($address)) {
            throw new \InvalidArgumentException('Address must be string');
        }
        if (!empty($addressConfirmed) && !is_bool($addressConfirmed)) {
            throw new \InvalidArgumentException('AddressConfirmed must be bool');
        }
        if (!empty($purposeToOpenAccount) && !is_string($purposeToOpenAccount)) {
            throw new \InvalidArgumentException('PurposeToOpenAccount must be string');
        }
        if (!empty($oneOperationLimit) && !is_int($oneOperationLimit) && !is_float($oneOperationLimit)) {
            throw new \InvalidArgumentException('OneOperationLimit must be float');
        }
        if (!empty($dailyLimit) && !is_int($dailyLimit) && !is_float($dailyLimit)) {
            throw new \InvalidArgumentException('DailyLimit must be float');
        }
        if (!empty($weeklyLimit) && !is_int($weeklyLimit) && !is_float($weeklyLimit)) {
            throw new \InvalidArgumentException('WeeklyLimit must be float');
        }
        if (!empty($monthlyLimit) && !is_int($monthlyLimit) && !is_float($monthlyLimit)) {
            throw new \InvalidArgumentException('MonthlyLimit must be float');
        }
        if (!empty($annualLimit) && !is_int($annualLimit) && !is_float($annualLimit)) {
            throw new \InvalidArgumentException('AnnualLimit must be float');
        }
        if (!empty($activeFeatures) && !is_array($activeFeatures)) {
            throw new \InvalidArgumentException('ActiveFeatures must be array');
        }
        if (!empty($promotions) && !is_array($promotions)) {
            throw new \InvalidArgumentException('Promotions must be array');
        }

        $this->clientProfileId = $clientProfileId;
        $this->sequenceId = $sequenceId;
        $this->userMerchantId = $userMerchantId;
        $this->accountStatus = $accountStatus;
        $this->regDate = $regDate;
        $this->phone = $phone;
        $this->phoneConfirmed = $phoneConfirmed;
        $this->email = $email;
        $this->emailConfirmed = $emailConfirmed;
        $this->userName = $userName;
        $this->password = $password;
        $this->companyName = $companyName;
        $this->websiteUrl = $websiteUrl;
        $this->industry = $industry;
        $this->fullname = $fullname;
        $this->hasMiddleName = $hasMiddleName;
        $this->birthDate = $birthDate;
        $this->gender = $gender;
        $this->maritalStatus = $maritalStatus;
        $this->nationality = $nationality;
        $this->education = $education;
        $this->employmentStatus = $employmentStatus;
        $this->sourceOfFunds = $sourceOfFunds;
        $this->documentCountry = $documentCountry;
        $this->documentConfirmed = $documentConfirmed;
        $this->regNumber = $regNumber;
        $this->issueDate = $issueDate;
        $this->expiryDate = $expiryDate;
        $this->vatNumber = $vatNumber;
        $this->vatConfirmed = $vatConfirmed;
        $this->declarationOfTrust = $declarationOfTrust;
        $this->description = $description;
        $this->country = $country;
        $this->state = $state;
        $this->city = $city;
        $this->zip = $zip;
        $this->address = $address;
        $this->addressConfirmed = $addressConfirmed;
        $this->purposeToOpenAccount = $purposeToOpenAccount;
        $this->oneOperationLimit = $oneOperationLimit;
        $this->dailyLimit = $dailyLimit;
        $this->weeklyLimit = $weeklyLimit;
        $this->monthlyLimit = $monthlyLimit;
        $this->annualLimit = $annualLimit;
        $this->activeFeatures = $activeFeatures;
        $this->promotions = $promotions;
    }

    /**
     * @return int|null
     */
    public function getClientProfileId()
    {
        return $this->clientProfileId;
    }

    /**
     * @return string|null
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    /**
     * @return string|null
     */
    public function getUserMerchantId()
    {
        return $this->userMerchantId;
    }

    /**
     * @return string|null
     */
    public function getAccountStatus()
    {
        return $this->accountStatus;
    }

    /**
     * @return int|null
     */
    public function getRegDate()
    {
        return $this->regDate;
    }

    /**
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return bool|null
     */
    public function getPhoneConfirmed()
    {
        return $this->phoneConfirmed;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return bool|null
     */
    public function getEmailConfirmed()
    {
        return $this->emailConfirmed;
    }

    /**
     * @return string|null
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @return string|null
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * @return string|null
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * @return string|null
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @return bool|null
     */
    public function getHasMiddleName()
    {
        return $this->hasMiddleName;
    }

    /**
     * @return int|null
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @return string|null
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return string|null
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }

    /**
     * @return string|null
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @return string|null
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @return string|null
     */
    public function getEmploymentStatus()
    {
        return $this->employmentStatus;
    }

    /**
     * @return string|null
     */
    public function getSourceOfFunds()
    {
        return $this->sourceOfFunds;
    }

    /**
     * @return string|null
     */
    public function getDocumentCountry()
    {
        return $this->documentCountry;
    }

    /**
     * @return bool|null
     */
    public function getDocumentConfirmed()
    {
        return $this->documentConfirmed;
    }

    /**
     * @return string|null
     */
    public function getRegNumber()
    {
        return $this->regNumber;
    }

    /**
     * @return int|null
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * @return int|null
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @return string|null
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    /**
     * @return bool|null
     */
    public function getVatConfirmed()
    {
        return $this->vatConfirmed;
    }

    /**
     * @return bool|null
     */
    public function getDeclarationOfTrust()
    {
        return $this->declarationOfTrust;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return bool|null
     */
    public function getAddressConfirmed()
    {
        return $this->addressConfirmed;
    }

    /**
     * @return string|null
     */
    public function getPurposeToOpenAccount()
    {
        return $this->purposeToOpenAccount;
    }

    /**
     * @return float|null
     */
    public function getOneOperationLimit()
    {
        return $this->oneOperationLimit;
    }

    /**
     * @return float|null
     */
    public function getDailyLimit()
    {
        return $this->dailyLimit;
    }

    /**
     * @return float|null
     */
    public function getWeeklyLimit()
    {
        return $this->weeklyLimit;
    }

    /**
     * @return float|null
     */
    public function getMonthlyLimit()
    {
        return $this->monthlyLimit;
    }

    /**
     * @return float|null
     */
    public function getAnnualLimit()
    {
        return $this->annualLimit;
    }

    /**
     * @return array|null
     */
    public function getActiveFeatures()
    {
        return $this->activeFeatures;
    }

    /**
     * @return array|null
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return [
            'client_profile_id' => $this->clientProfileId,
            'sequence_id' => $this->sequenceId,
            'user_merchant_id' => $this->userMerchantId,
            'account_status' => $this->accountStatus,
            'reg_date' => $this->regDate,
            'phone' => $this->phone,
            'phone_confirmed' => $this->phoneConfirmed,
            'email' => $this->email,
            'email_confirmed' => $this->emailConfirmed,
            'user_name' => $this->userName,
            'password' => $this->password,
            'company_name' => $this->companyName,
            'website_url' => $this->websiteUrl,
            'industry' => $this->industry,
            'fullname' => $this->fullname,
            'has_middle_name' => $this->hasMiddleName,
            'birth_date' => $this->birthDate,
            'gender' => $this->gender,
            'marital_status' => $this->maritalStatus,
            'nationality' => $this->nationality,
            'education' => $this->education,
            'employment_status' => $this->employmentStatus,
            'source_of_funds' => $this->sourceOfFunds,
            'document_country' => $this->documentCountry,
            'document_confirmed' => $this->documentConfirmed,
            'reg_number' => $this->regNumber,
            'issue_date' => $this->issueDate,
            'expiry_date' => $this->expiryDate,
            'vat_number' => $this->vatNumber,
            'vat_confirmed' => $this->vatConfirmed,
            'declaration_of_trust' => $this->declarationOfTrust,
            'description' => $this->description,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'zip' => $this->zip,
            'address' => $this->address,
            'address_confirmed' => $this->addressConfirmed,
            'purpose_to_open_account' => $this->purposeToOpenAccount,
            'one_operation_limit' => $this->oneOperationLimit,
            'daily_limit' => $this->dailyLimit,
            'weekly_limit' => $this->weeklyLimit,
            'monthly_limit' => $this->monthlyLimit,
            'annual_limit' => $this->annualLimit,
            'active_features' => $this->activeFeatures,
            'promotions' => $this->promotions,
        ];
    }
}
