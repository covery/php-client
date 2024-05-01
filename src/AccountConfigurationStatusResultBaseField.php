<?php

namespace Covery\Client;

/**
 * Class AccountConfigurationStatusResultBaseField
 * @package Covery\Client
 */
class AccountConfigurationStatusResultBaseField
{
    const ACTUAL_EVENT_TYPES = 'actualEventTypes';
    const BASE_CURRENCY = 'baseCurrency';
    const DECISION_CALLBACK_URL = 'decisionCallbackUrl';
    const MANUAL_DECISION_CALLBACK_URL = 'manualDecisionCallbackUrl';
    const ONGOING_MONITORING_WEBHOOK_URL = 'ongoingMonitoringWebhookUrl';
    const DOCUMENT_STORAGE_WEBHOOK_URL = 'documentStorageWebhookUrl';
    const FRAUD_ALERT_CALLBACK_URL = 'fraudAlertCallbackUrl';
    const CARD_ID_GENERATION = 'cardIdGeneration';
    const DEVICE_FINGERPRINT_GENERATION = 'deviceFingerprintGeneration';
    const SEQUENCE_ID_GENERATION = 'sequenceIdGeneration';
    const SEQUENCE_ID_GENERATION_METHOD = 'sequenceIdGenerationMethod';
    const AML_SERVICE = 'amlService';
    const AML_SERVICE_STATUS = 'amlServiceStatus';
    const DOW_JONES_DATA_BASE_DATE = 'dowJonesDataBaseDate';
    const KYC_PROVIDER = 'kycProvider';
}
