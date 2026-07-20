<?php

namespace Covery\Client;

/**
 * Class AccountConfigurationStatusResult
 *
 * Contains Account Configuration Status result data, received from Covery
 *
 * @package Covery\Client
 */
class AccountConfigurationStatusResult
{
    /**
     * @var array|null
     */
    private $actualEventTypes;
    /**
     * @var string|null
     */
    private $baseCurrency;
    /**
     * @var string|null
     */
    private $decisionCallbackUrl;
    /**
     * @var string|null
     */
    private $manualDecisionCallbackUrl;
    /**
     * @var string|null
     */
    private $ongoingMonitoringWebhookUrl;
    /**
     * @var string|null
     */
    private $documentStorageWebhookUrl;
    /**
     * @var string|null
     */
    private $fraudAlertCallbackUrl;
    /**
     * @var bool|null
     */
    private $cardIdGeneration;
    /**
     * @var bool|null
     */
    private $deviceFingerprintGeneration;
    /**
     * @var bool|null
     */
    private $sequenceIdGeneration;
    /**
     * @var string|null
     */
    private $sequenceIdGenerationMethod;
    /**
     * @var string|null
     */
    private $amlService;
    /**
     * @var bool|null
     */
    private $amlServiceStatus;
    /**
     * @var int|null
     */
    private $dowJonesDataBaseDate;
    /**
     * @var string|null
     */
    private $kycProvider;

    /**
     * AccountConfigurationStatusResult constructor.
     *
     * @param $actualEventTypes
     * @param $baseCurrency
     * @param $decisionCallbackUrl
     * @param $manualDecisionCallbackUrl
     * @param $ongoingMonitoringWebhookUrl
     * @param $documentStorageWebhookUrl
     * @param $fraudAlertCallbackUrl
     * @param $cardIdGeneration
     * @param $deviceFingerprintGeneration
     * @param $sequenceIdGeneration
     * @param $sequenceIdGenerationMethod
     * @param $amlService
     * @param $amlServiceStatus
     * @param $dowJonesDataBaseDate
     * @param $kycProvider
     */
    public function __construct(
        $actualEventTypes,
        $baseCurrency,
        $decisionCallbackUrl,
        $manualDecisionCallbackUrl,
        $ongoingMonitoringWebhookUrl,
        $documentStorageWebhookUrl,
        $fraudAlertCallbackUrl,
        $cardIdGeneration,
        $deviceFingerprintGeneration,
        $sequenceIdGeneration,
        $sequenceIdGenerationMethod,
        $amlService,
        $amlServiceStatus,
        $dowJonesDataBaseDate,
        $kycProvider
    ) {
        self::assertOptional($actualEventTypes, 'is_array', "Actual Event Types must be array");
        self::assertOptional($baseCurrency, 'is_string', "Base Currency must be string");
        self::assertOptional($decisionCallbackUrl, 'is_string', "Decision Callback Url must be string");
        self::assertOptional($manualDecisionCallbackUrl, 'is_string', "Manual Decision Callback Url must be string");
        self::assertOptional($ongoingMonitoringWebhookUrl, 'is_string', "Ongoing Monitoring Webhook Url must be string");
        self::assertOptional($documentStorageWebhookUrl, 'is_string', "Document Storage Webhook Url Url must be string");
        self::assertOptional($fraudAlertCallbackUrl, 'is_string', "Fraud Alert Callback Url must be string");
        self::assertOptional($cardIdGeneration, 'is_bool', "Card Id Generation must be string");
        self::assertOptional($deviceFingerprintGeneration, 'is_bool', "Device Fingerprint Generation must be string");
        self::assertOptional($sequenceIdGeneration, 'is_bool', "Sequence Id Generation must be string");
        self::assertOptional($sequenceIdGenerationMethod, 'is_string', "Sequence Id Generation Method must be string");
        self::assertOptional($amlService, 'is_string', "Aml Service must be string");
        self::assertOptional($amlServiceStatus, 'is_bool', "Aml Service Status must be string");
        self::assertOptional($dowJonesDataBaseDate, 'is_int', "Dow Jones Data Base Date must be integer");
        self::assertOptional($kycProvider, 'is_string', "Kyc Provider must be string");

        $this->actualEventTypes = $actualEventTypes;
        $this->baseCurrency = $baseCurrency;
        $this->decisionCallbackUrl = $decisionCallbackUrl;
        $this->manualDecisionCallbackUrl = $manualDecisionCallbackUrl;
        $this->ongoingMonitoringWebhookUrl = $ongoingMonitoringWebhookUrl;
        $this->documentStorageWebhookUrl = $documentStorageWebhookUrl;
        $this->fraudAlertCallbackUrl = $fraudAlertCallbackUrl;
        $this->cardIdGeneration = $cardIdGeneration;
        $this->deviceFingerprintGeneration = $deviceFingerprintGeneration;
        $this->sequenceIdGeneration = $sequenceIdGeneration;
        $this->sequenceIdGenerationMethod = $sequenceIdGenerationMethod;
        $this->amlService = $amlService;
        $this->amlServiceStatus = $amlServiceStatus;
        $this->dowJonesDataBaseDate = $dowJonesDataBaseDate;
        $this->kycProvider = $kycProvider;
    }

    /**
     * @return array
     */
    public function getActualEventTypes()
    {
        return $this->actualEventTypes;
    }

    /**
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * @return string
     */
    public function getDecisionCallbackUrl()
    {
        return $this->decisionCallbackUrl;
    }

    /**
     * @return string
     */
    public function getManualDecisionCallbackUrl()
    {
        return $this->manualDecisionCallbackUrl;
    }

    /**
     * @return string
     */
    public function getOngoingMonitoringWebhookUrl()
    {
        return $this->ongoingMonitoringWebhookUrl;
    }

    /**
     * @return string
     */
    public function getDocumentStorageWebhookUrl()
    {
        return $this->documentStorageWebhookUrl;
    }

    /**
     * @return string
     */
    public function getFraudAlertCallbackUrl()
    {
        return $this->fraudAlertCallbackUrl;
    }

    /**
     * @return bool
     */
    public function isCardIdGeneration()
    {
        return $this->cardIdGeneration;
    }

    /**
     * @return bool
     */
    public function isDeviceFingerprintGeneration()
    {
        return $this->deviceFingerprintGeneration;
    }

    /**
     * @return bool
     */
    public function isSequenceIdGeneration()
    {
        return $this->sequenceIdGeneration;
    }

    /**
     * @return string
     */
    public function getSequenceIdGenerationMethod()
    {
        return $this->sequenceIdGenerationMethod;
    }

    /**
     * @return string
     */
    public function getAmlService()
    {
        return $this->amlService;
    }

    /**
     * @return bool
     */
    public function isAmlServiceStatus()
    {
        return $this->amlServiceStatus;
    }

    /**
     * @return int
     */
    public function getDowJonesDataBaseDate()
    {
        return $this->dowJonesDataBaseDate;
    }

    /**
     * @return string
     */
    public function getKycProvider()
    {
        return $this->kycProvider;
    }

    /**
     * Validates that a non-empty value satisfies the given type check.
     *
     * @param mixed    $value   Value to validate; empty values are always accepted
     * @param callable $check   Type-check callback (e.g. 'is_string', 'is_bool')
     * @param string   $message Exception message thrown when the check fails
     * @throws \InvalidArgumentException
     */
    private static function assertOptional($value, callable $check, $message)
    {
        if (!empty($value) && !$check($value)) {
            throw new \InvalidArgumentException($message);
        }
    }
}
