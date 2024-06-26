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
     * @var string|null
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
        if (!empty($actualEventTypes) && !is_array($actualEventTypes)) {
            throw new \InvalidArgumentException("Actual Event Types must be array");
        }
        if (!empty($baseCurrency) && !is_string($baseCurrency)) {
            throw new \InvalidArgumentException("Base Currency must be string");
        }
        if (!empty($decisionCallbackUrl) && !is_string($decisionCallbackUrl)) {
            throw new \InvalidArgumentException("Decision Callback Url must be string");
        }
        if (!empty($manualDecisionCallbackUrl) && !is_string($manualDecisionCallbackUrl)) {
            throw new \InvalidArgumentException("Manual Decision Callback Url must be string");
        }
        if (!empty($ongoingMonitoringWebhookUrl) && !is_string($ongoingMonitoringWebhookUrl)) {
            throw new \InvalidArgumentException("Ongoing Monitoring Webhook Url must be string");
        }
        if (!empty($documentStorageWebhookUrl) && !is_string($documentStorageWebhookUrl)) {
            throw new \InvalidArgumentException("Document Storage Webhook Url Url must be string");
        }
        if (!empty($fraudAlertCallbackUrl) && !is_string($fraudAlertCallbackUrl)) {
            throw new \InvalidArgumentException("Fraud Alert Callback Url must be string");
        }
        if (!empty($cardIdGeneration) && !is_bool($cardIdGeneration)) {
            throw new \InvalidArgumentException("Card Id Generation must be string");
        }
        if (!empty($deviceFingerprintGeneration) && !is_bool($deviceFingerprintGeneration)) {
            throw new \InvalidArgumentException("Device Fingerprint Generation must be string");
        }
        if (!empty($sequenceIdGeneration) && !is_bool($sequenceIdGeneration)) {
            throw new \InvalidArgumentException("Sequence Id Generation must be string");
        }
        if (!empty($sequenceIdGenerationMethod) && !is_string($sequenceIdGenerationMethod)) {
            throw new \InvalidArgumentException("Sequence Id Generation Method must be string");
        }
        if (!empty($amlService) && !is_string($amlService)) {
            throw new \InvalidArgumentException("Aml Service must be string");
        }
        if (!empty($amlServiceStatus) && !is_bool($amlServiceStatus)) {
            throw new \InvalidArgumentException("Aml Service Status must be string");
        }
        if (!empty($dowJonesDataBaseDate) && !is_int($dowJonesDataBaseDate)) {
            throw new \InvalidArgumentException("Dow Jones Data Base Date must be integer");
        }
        if (!empty($kycProvider) && !is_string($kycProvider)) {
            throw new \InvalidArgumentException("Kyc Provider must be string");
        }

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
}
