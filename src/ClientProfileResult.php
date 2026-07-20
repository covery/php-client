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
        Validation::optionalInt($clientProfileId, 'ClientProfileId must be int');
        Validation::optionalString($sequenceId, 'SequenceId must be string');
        Validation::optionalString($userMerchantId, 'UserMerchantId must be string');
        Validation::optionalString($accountStatus, 'AccountStatus must be string');
        Validation::optionalInt($regDate, 'RegDate must be int');
        Validation::optionalString($phone, 'Phone must be string');
        Validation::optionalBool($phoneConfirmed, 'PhoneConfirmed must be bool');
        Validation::optionalString($email, 'Email must be string');
        Validation::optionalBool($emailConfirmed, 'EmailConfirmed must be bool');
        Validation::optionalString($userName, 'UserName must be string');
        Validation::optionalString($password, 'Password must be string');
        Validation::optionalString($companyName, 'CompanyName must be string');
        Validation::optionalString($websiteUrl, 'WebsiteUrl must be string');
        Validation::optionalString($industry, 'Industry must be string');
        Validation::optionalString($fullname, 'Fullname must be string');
        Validation::optionalBool($hasMiddleName, 'HasMiddleName must be bool');
        Validation::optionalInt($birthDate, 'BirthDate must be int');
        Validation::optionalString($gender, 'Gender must be string');
        Validation::optionalString($maritalStatus, 'MaritalStatus must be string');
        Validation::optionalString($nationality, 'Nationality must be string');
        Validation::optionalString($education, 'Education must be string');
        Validation::optionalString($employmentStatus, 'EmploymentStatus must be string');
        Validation::optionalString($sourceOfFunds, 'SourceOfFunds must be string');
        Validation::optionalString($documentCountry, 'DocumentCountry must be string');
        Validation::optionalBool($documentConfirmed, 'DocumentConfirmed must be bool');
        Validation::optionalString($regNumber, 'RegNumber must be string');
        Validation::optionalInt($issueDate, 'IssueDate must be int');
        Validation::optionalInt($expiryDate, 'ExpiryDate must be int');
        Validation::optionalString($vatNumber, 'VatNumber must be string');
        Validation::optionalBool($vatConfirmed, 'VatConfirmed must be bool');
        Validation::optionalBool($declarationOfTrust, 'DeclarationOfTrust must be bool');
        Validation::optionalString($description, 'Description must be string');
        Validation::optionalString($country, 'Country must be string');
        Validation::optionalString($state, 'State must be string');
        Validation::optionalString($city, 'City must be string');
        Validation::optionalString($zip, 'Zip must be string');
        Validation::optionalString($address, 'Address must be string');
        Validation::optionalBool($addressConfirmed, 'AddressConfirmed must be bool');
        Validation::optionalString($purposeToOpenAccount, 'PurposeToOpenAccount must be string');
        Validation::optionalNumber($oneOperationLimit, 'OneOperationLimit must be float');
        Validation::optionalNumber($dailyLimit, 'DailyLimit must be float');
        Validation::optionalNumber($weeklyLimit, 'WeeklyLimit must be float');
        Validation::optionalNumber($monthlyLimit, 'MonthlyLimit must be float');
        Validation::optionalNumber($annualLimit, 'AnnualLimit must be float');
        Validation::optionalArray($activeFeatures, 'ActiveFeatures must be array');
        Validation::optionalArray($promotions, 'Promotions must be array');

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
