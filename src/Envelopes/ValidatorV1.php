<?php

namespace Covery\Client\Envelopes;

use Covery\Client\EnvelopeInterface;
use Covery\Client\EnvelopeValidationException;
use Covery\Client\IdentityNodeInterface;

class ValidatorV1
{
    private static $dataTypes = array(
        'billing_address' => 'string(255)',
        'billing_city' => 'string(255)',
        'billing_country' => 'string(255)',
        'billing_firstname' => 'string(255)',
        'billing_lastname' => 'string(255)',
        'billing_fullname' => 'string(512)',
        'billing_state' => 'string(255)',
        'billing_zip' => 'string(255)',
        'card_id' => 'string(255)',
        'card_last4' => 'string(4)',
        'country' => 'string(255)',
        'cpu_class' => 'string(255)',
        'device_fingerprint' => 'string(255)',
        'device_id' => 'string(255)',
        'firstname' => 'string(255)',
        'gender' => 'string(255)',
        'language' => 'string(255)',
        'language_browser' => 'string(255)',
        'language_system' => 'string(255)',
        'language_user' => 'string(255)',
        'languages' => 'string(1024)',
        'lastname' => 'string(255)',
        'os' => 'string(255)',
        'payment_method' => 'string(255)',
        'payment_mid' => 'string(255)',
        'payment_system' => 'string(255)',
        'payment_account_id' => 'string(255)',
        'product_description' => 'string(1024)',
        'product_name' => 'string(255)',
        'screen_orientation' => 'string(255)',
        'screen_resolution' => 'string(255)',
        'social_type' => 'string(255)',
        'birth_date' => 'int',
        'fullname' => 'string(512)',
        'state' => 'string(255)',
        'city' => 'string(255)',
        'address' => 'string(255)',
        'zip' => 'string(255)',
        'transaction_currency' => 'string(255)',
        'transaction_id' => 'string(255)',
        'transaction_mode' => 'string(255)',
        'transaction_type' => 'string(255)',
        'user_agent' => 'string(2048)',
        'local_ip_list' => 'string(1024)',
        'plugins' => 'string(1024)',
        'referer_url' => 'string(2048)',
        'origin_url' => 'string(2048)',
        'client_resolution' => 'string(255)',
        'user_merchant_id' => 'string(255)',
        'user_name' => 'string(255)',
        'website_url' => 'string(255)',
        'transaction_source' => 'string(255)',
        'ip' => 'string(255)',
        'merchant_ip' => 'string(255)',
        'real_ip' => 'string(255)',
        'email' => 'string(255)',
        'phone' => 'string(255)',
        'age' => 'int',
        'card_bin' => 'int',
        'confirmation_timestamp' => 'int',
        'expiration_month' => 'int',
        'expiration_year' => 'int',
        'login_timestamp' => 'int',
        'registration_timestamp' => 'int',
        'timezone_offset' => 'int',
        'transaction_timestamp' => 'int',
        'product_quantity' => 'float',
        'transaction_amount' => 'float',
        'transaction_amount_converted' => 'float',
        'ajax_validation' => 'bool',
        'cookie_enabled' => 'bool',
        'do_not_track' => 'bool',
        'email_confirmed' => 'bool',
        'login_failed' => 'bool',
        'phone_confirmed' => 'bool',
        'traffic_source' => 'string(255)',
        'affiliate_id' => 'string(255)',
        'payout_id' => 'string(255)',
        'payout_timestamp' => 'int',
        'payout_account_id' => 'string(255)',
        'payout_card_id' => 'string(255)',
        'payout_amount' => 'float',
        'payout_currency' => 'string(255)',
        'payout_method' => 'string(255)',
        'payout_system' => 'string(255)',
        'payout_mid' => 'string(255)',
        'payout_amount_converted' => 'float',
        'payout_card_bin' => 'int',
        'payout_card_last4' => 'string(4)',
        'payout_expiration_month' => 'int',
        'payout_expiration_year' => 'int',
        'install_timestamp' => 'int',
        'refund_timestamp' => 'int',
        'refund_id' => 'string(255)',
        'refund_amount' => 'float',
        'refund_currency' => 'string(255)',
        'refund_amount_converted' => 'float',
        'refund_source' => 'string(255)',
        'refund_type' => 'string(255)',
        'refund_code' => 'string(255)',
        'refund_reason' => 'string(255)',
        'refund_method' => 'string(255)',
        'refund_system' => 'string(255)',
        'refund_mid' => 'string(255)',
        'event_id' => 'string(255)',
        'event_timestamp' => 'int',
        'amount' => 'float',
        'amount_converted' => 'float',
        'currency' => 'string(255)',
        'account_id' => 'string(255)',
        'account_system' => 'string(255)',
        'method' => 'string(255)',
        'second_account_id' => 'string(255)',
        'operation' => 'string(255)',
        'second_email' => 'string(255)',
        'second_phone' => 'string(255)',
        'second_birth_date' => 'int',
        'second_firstname' => 'string(255)',
        'second_lastname' => 'string(255)',
        'second_fullname' => 'string(512)',
        'second_state' => 'string(255)',
        'second_city' => 'string(255)',
        'second_address' => 'string(255)',
        'second_zip' => 'string(255)',
        'second_gender' => 'string(255)',
        'second_country' => 'string(255)',
        'agent_id' => 'string(255)',
        'transaction_status' => 'string(255)',
        'code' => 'string(255)',
        'reason' => 'string(255)',
        'secure3d' => 'string(255)',
        'avs_result' => 'string(255)',
        'cvv_result' => 'string(255)',
        'psp_code' => 'string(255)',
        'psp_reason' => 'string(255)',
        'arn' => 'string(255)',
        'password' => 'string(255)',
        'iban' => 'string(255)',
        'second_iban' => 'string(255)',
        'request_id' =>  'int',
        'group_id' => 'string(255)',
        'status' => 'string(255)',
        'provider_result' => 'string(255)',
        'provider_code' => 'string(255)',
        'provider_reason' => 'string(255)',
        'profile_id' => 'string(255)',
        'profile_type' => 'string(255)',
        'profile_sub_type' => 'string(255)',
        'industry' => 'string(255)',
        'description' => 'string(1024)',
        'reg_date' => 'int',
        'reg_number' => 'string(255)',
        'vat_number' => 'string(255)',
        'bic' => 'string(255)',
        'campaign' => 'string(255)',
        'transfer_source' => 'string(255)',
        "items_quantity" => 'int',
        "order_type" => 'string(255)',
        "carrier" => 'string(255)',
        "carrier_shipping_id" => 'string(255)',
        "coupon_end_date" => 'int',
        "coupon_id" => 'string(255)',
        "coupon_name" => 'string(255)',
        "coupon_start_date" => 'int',
        "customer_comment" => 'string(255)',
        "delivery_estimate" => 'int',
        "shipping_address" => 'string(255)',
        "shipping_city" => 'string(255)',
        "shipping_country" => 'string(255)',
        "shipping_currency" => 'string(255)',
        "shipping_fee" => 'float',
        "shipping_fee_converted" => 'float',
        "shipping_state" => 'string(255)',
        "shipping_zip" => 'string(255)',
        "order_source" => 'string(255)',
        "source_fee" => 'float',
        "source_fee_currency" => 'string(255)',
        "source_fee_converted" => 'float',
        "tax_currency" => 'string(255)',
        "tax_fee" => 'float',
        "tax_fee_converted" => 'float',
        "product_url" => 'string(255)',
        "product_image_url" => 'string(255)',
        "carrier_url" => 'string(255)',
        "carrier_phone" => 'string(255)',
        'merchant_country' => 'string(255)',
        'mcc' => 'string(255)',
        'acquirer_merchant_id' => 'string(255)',
        'provider_id' => 'string(255)',
        'contact_email' => 'string(255)',
        'contact_phone' => 'string(255)',
        'wallet_type' => 'string(255)',
        'nationality' => 'string(255)',
        'final_beneficiary' => 'bool',
        'employment_status' => 'string(255)',
        'source_of_funds' => 'string(255)',
        'issue_date' => 'int',
        'expiry_date' => 'int',
        'verification_mode' => 'string(255)',
        'verification_source' => 'string(255)',
        'consent' => 'bool',
        'allow_na_ocr_inputs' => 'bool',
        'decline_on_single_step' => 'bool',
        'backside_proof' => 'bool',
        'kyc_language' => 'string(255)',
        'redirect_url' => 'string(255)',
        'number_of_documents' => 'int',
        'kyc_start_id' => 'int',
        'second_user_merchant_id' => 'string(255)',
        'allowed_document_format' => 'string(255)',
        '2fa_allowed' => 'bool',
        'game_level' => 'string(255)',
        'marital_status' => 'string(255)',
        'physique' => 'string(255)',
        'height' => 'float',
        'weight' => 'float',
        'hair' => 'string(255)',
        'eyes' => 'string(255)',
        'education' => 'string(255)',
        'address_confirmed' => 'bool',
        'second_address_confirmed' => 'bool',
        'document_country' => 'string(255)',
        'document_confirmed' => 'bool',
        'purpose_to_open_account' => 'string(255)',
        'one_operation_limit' => 'float',
        'daily_limit' => 'float',
        'weekly_limit' => 'float',
        'monthly_limit' => 'float',
        'annual_limit' => 'float',
        'active_features' => 'string(1024)',
        'promotions' => 'string(1024)',
        'links_to_documents' => 'string(2048)',
        'media_id' => 'array',
    );

    private static $sharedOptional = array(
        'ajax_validation',
        'cookie_enabled',
        'cpu_class',
        'device_fingerprint',
        'device_id',
        'do_not_track',
        'ip',
        'language',
        'language_browser',
        'language_system',
        'language_user',
        'languages',
        'os',
        'real_ip',
        'screen_orientation',
        'screen_resolution',
        'timezone_offset',
        'user_agent',
        'local_ip_list',
        'plugins',
        'referer_url',
        'origin_url',
        'client_resolution'
    );

    private static $types = array(
        'confirmation' => array(
            'mandatory' => array('confirmation_timestamp', 'user_merchant_id'),
            'optional' => array('email_confirmed', 'phone_confirmed', 'email', 'phone', "group_id", "media_id"),
        ),
        'login' => array(
            'mandatory' => array('login_timestamp', 'user_merchant_id'),
            'optional' => array(
                'email',
                'login_failed',
                'phone',
                'gender',
                'traffic_source',
                'affiliate_id',
                'password',
                'campaign',
                "group_id",
                "media_id",
            )
        ),
        'registration' => array(
            'mandatory' => array('registration_timestamp', 'user_merchant_id'),
            'optional' => array(
                'age',
                'country',
                'email',
                'firstname',
                'gender',
                'lastname',
                'phone',
                'social_type',
                'user_name',
                'website_url',
                'traffic_source',
                'affiliate_id',
                'password',
                'campaign',
                "group_id",
                "media_id",
            ),
        ),
        'transaction' => array(
            'mandatory' => array(
                'transaction_amount',
                'transaction_currency',
                'transaction_id',
                'transaction_timestamp',
                'user_merchant_id',
            ),
            'optional' => array(
                'transaction_mode',
                'transaction_type',
                'card_bin',
                'card_id',
                'card_last4',
                'expiration_month',
                'expiration_year',
                'age',
                'country',
                'email',
                'firstname',
                'gender',
                'lastname',
                'phone',
                'user_name',
                'payment_method',
                'payment_mid',
                'payment_system',
                'payment_account_id',
                'transaction_amount_converted',
                'transaction_source',
                'billing_address',
                'billing_city',
                'billing_country',
                'billing_firstname',
                'billing_lastname',
                'billing_fullname',
                'billing_state',
                'billing_zip',
                'product_description',
                'product_name',
                'product_quantity',
                'website_url',
                'merchant_ip',
                'affiliate_id',
                'campaign',
                'merchant_country',
                'mcc',
                'acquirer_merchant_id',
                'group_id',
                'links_to_documents',
                'media_id',
            )
        ),
        'payout' => array(
            'mandatory' => array(
                'payout_timestamp',
                'payout_id',
                'user_merchant_id',
                'payout_amount',
                'payout_currency',
            ),
            'optional' => array(
                'payout_card_id',
                'payout_account_id',
                'payout_method',
                'payout_system',
                'payout_mid',
                'payout_amount_converted',
                'firstname',
                'lastname',
                'country',
                'email',
                'phone',
                'payout_card_bin',
                'payout_card_last4',
                'payout_expiration_month',
                'payout_expiration_year',
                'group_id',
                'links_to_documents',
                'media_id',
            )
        ),
        'install' => array(
            'mandatory' => array(
                'install_timestamp',
            ),
            'optional' => array(
                'user_merchant_id',
                'country',
                'website_url',
                'traffic_source',
                'affiliate_id',
                'campaign',
                "group_id",
                "media_id",
            )
        ),
        'refund' => array(
            'mandatory' => array(
                'refund_timestamp',
                'refund_id',
                'refund_amount',
                'refund_currency',
            ),
            'optional' => array(
                'refund_amount_converted',
                'refund_source',
                'refund_type',
                'refund_code',
                'refund_reason',
                'refund_method',
                'refund_system',
                'refund_mid',
                'agent_id',
                'email',
                'phone',
                'user_merchant_id',
                'group_id',
                'links_to_documents',
                'media_id',
            )
        ),
        'transfer' => array(
            'mandatory' => array(
                'event_id',
                'event_timestamp',
                'amount',
                'currency',
                'user_merchant_id',
            ),
            'optional' => array(
                'method',
                'amount_converted',
                'email',
                'phone',
                'birth_date',
                'firstname',
                'lastname',
                'fullname',
                'state',
                'city',
                'address',
                'zip',
                'gender',
                'country',
                'operation',
                'second_email',
                'second_phone',
                'second_birth_date',
                'second_firstname',
                'second_lastname',
                'second_fullname',
                'second_state',
                'second_city',
                'second_address',
                'second_zip',
                'second_gender',
                'second_country',
                'product_description',
                'product_name',
                'product_quantity',
                'iban',
                'second_iban',
                'bic',
                'transfer_source',
                "group_id",
                "second_user_merchant_id",
                'account_system',
                'account_id',
                'second_account_id',
                'links_to_documents',
                'media_id',
            )
        ),
        'postback' => array(
            'mandatory' => array(),
            'optional' => array(
                'request_id',
                'transaction_id',
                'transaction_status',
                'code',
                'reason',
                'secure3d',
                'avs_result',
                'cvv_result',
                'psp_code',
                'psp_reason',
                'arn',
                'payment_account_id',
            )
        ),
        'kyc_profile' => array(
            'mandatory' => array(
                'event_id',
                'event_timestamp',
                'user_merchant_id',
            ),
            'optional' => array(
                'group_id',
                'status',
                'code',
                'reason',
                'provider_result',
                'provider_code',
                'provider_reason',
                'profile_id',
                'profile_type',
                'profile_sub_type',
                'firstname',
                'lastname',
                'fullname',
                'industry',
                'website_url',
                'description',
                'birth_date',
                'reg_date',
                'reg_number',
                'vat_number',
                'email',
                'email_confirmed',
                'phone',
                'phone_confirmed',
                'country',
                'state',
                'city',
                'address',
                'zip',
                'second_country',
                'second_state',
                'second_city',
                'second_address',
                'second_zip',
                'provider_id',
                'contact_email',
                'contact_phone',
                'wallet_type',
                'nationality',
                'final_beneficiary',
                'employment_status',
                'source_of_funds',
                'issue_date',
                'expiry_date',
                'gender',
                'links_to_documents',
                'media_id',
                'address_confirmed',
                'second_address_confirmed',
            )
        ),
        'kyc_submit' => array(
            'mandatory' => array(
                'event_id',
                'event_timestamp',
                'user_merchant_id',
            ),
            'optional' => array(
                'group_id',
                'status',
                'code',
                'reason',
                'provider_result',
                'provider_code',
                'provider_id',
                'provider_reason',
                'links_to_documents',
                'profile_id',
                'profile_type',
                'profile_sub_type',
                'firstname',
                'lastname',
                'fullname',
                'gender',
                'industry',
                'wallet_type',
                'website_url',
                'description',
                'employment_status',
                'source_of_funds',
                'birth_date',
                'reg_date',
                'issue_date',
                'expiry_date',
                'reg_number',
                'vat_number',
                'email',
                'email_confirmed',
                'phone',
                'phone_confirmed',
                'contact_email',
                'contact_phone',
                'country',
                'state',
                'city',
                'address',
                'zip',
                'nationality',
                'second_country',
                'second_state',
                'second_city',
                'second_address',
                'second_zip',
                'ajax_validation',
                'cookie_enabled',
                'cpu_class',
                'device_fingerprint',
                'device_id',
                'do_not_track',
                'ip',
                'real_ip',
                'local_ip_list',
                'language',
                'languages',
                'language_browser',
                'language_user',
                'language_system',
                'os',
                'screen_resolution',
                'screen_orientation',
                'client_resolution',
                'timezone_offset',
                'user_agent',
                'plugins',
                'referer_url',
                'origin_url',
                'media_id',
                'address_confirmed',
                'second_address_confirmed',
            )
        ),
        'kyc_start' => array(
            'mandatory' => array(
                'event_timestamp',
                'event_id',
                'user_merchant_id',
                'verification_mode',
                'verification_source',
                'consent',
            ),
            'optional' => array(
                'allow_na_ocr_inputs',
                'decline_on_single_step',
                'backside_proof',
                'group_id',
                'country',
                'kyc_language',
                'redirect_url',
                'email',
                'firstname',
                'lastname',
                'profile_id',
                'phone',
                'birth_date',
                'reg_number',
                'issue_date',
                'expiry_date',
                'number_of_documents',
                'allowed_document_format',
            )
        ),
        'kyc_proof' => array(
            'mandatory' => array(
                'kyc_start_id',
            ),
            'optional' => array()
        ),
        'order_item' => array(
            'mandatory' => array(
                'amount',
                'currency',
                'event_id',
                'event_timestamp',
                'order_type',
            ),
            'optional' => array(
                "affiliate_id",
                "amount_converted",
                "campaign",
                "carrier",
                "carrier_shipping_id",
                "coupon_end_date",
                "coupon_id",
                "coupon_name",
                "coupon_start_date",
                "customer_comment",
                "delivery_estimate",
                "email",
                "firstname",
                "lastname",
                "phone",
                "product_description",
                "product_name",
                "product_quantity",
                "shipping_address",
                "shipping_city",
                "shipping_country",
                "shipping_currency",
                "shipping_fee",
                "shipping_fee_converted",
                "shipping_state",
                "shipping_zip",
                "social_type",
                "order_source",
                "source_fee",
                "source_fee_currency",
                "source_fee_converted",
                "tax_currency",
                "tax_fee",
                "tax_fee_converted",
                "transaction_id",
                "user_merchant_id",
                "website_url",
                "group_id",
                "product_url",
                "product_image_url",
                "carrier_url",
                "carrier_phone",
                'media_id',
            )
        ),
        'order_submit' => array(
            'mandatory' => array(
                'amount',
                'currency',
                'event_id',
                'event_timestamp',
                'items_quantity',
            ),
            'optional' => array(
                "affiliate_id",
                "amount_converted",
                "campaign",
                "carrier",
                "carrier_shipping_id",
                "coupon_end_date",
                "coupon_id",
                "coupon_name",
                "coupon_start_date",
                "customer_comment",
                "delivery_estimate",
                "email",
                "firstname",
                "lastname",
                "phone",
                "shipping_address",
                "shipping_city",
                "shipping_country",
                "shipping_currency",
                "shipping_fee",
                "shipping_fee_converted",
                "shipping_state",
                "shipping_zip",
                "social_type",
                "order_source",
                "source_fee",
                "source_fee_currency",
                "source_fee_converted",
                "tax_currency",
                "tax_fee",
                "tax_fee_converted",
                "transaction_id",
                "user_merchant_id",
                "website_url",
                "group_id",
                "product_url",
                "product_image_url",
                "carrier_url",
                "carrier_phone",
                'media_id',
            )
        ),
        'profile_update' => array(
            'mandatory' => array(
                "event_id",
                "event_timestamp",
                "user_merchant_id",
            ),
            'optional' => array(
                "sequence_id",
                "group_id",
                "operation",
                "account_id",
                "account_system",
                "currency",
                "phone",
                "phone_confirmed",
                "email",
                "email_confirmed",
                "contact_email",
                "contact_phone",
                "2fa_allowed",
                "user_name",
                "password",
                "social_type",
                "game_level",
                "firstname",
                "lastname",
                "fullname",
                "birth_date",
                "age",
                "gender",
                "marital_status",
                "nationality",
                "physique",
                "height",
                "weight",
                "hair",
                "eyes",
                "education",
                "employment_status",
                "source_of_funds",
                "industry",
                "final_beneficiary",
                "wallet_type",
                "website_url",
                "description",
                "country",
                "state",
                "city",
                "zip",
                "address",
                "address_confirmed",
                "second_country",
                "second_state",
                "second_city",
                "second_zip",
                "second_address",
                "second_address_confirmed",
                "profile_id",
                "profile_type",
                "profile_sub_type",
                "document_country",
                "document_confirmed",
                "reg_date",
                "issue_date",
                "expiry_date",
                "reg_number",
                "vat_number",
                "purpose_to_open_account",
                "one_operation_limit",
                "daily_limit",
                "weekly_limit",
                "monthly_limit",
                "annual_limit",
                "active_features",
                "promotions",
                "ajax_validation",
                "cookie_enabled",
                "cpu_class",
                "device_fingerprint",
                "device_id",
                "do_not_track",
                "ip",
                "real_ip",
                "local_ip_list",
                "language",
                "languages",
                "language_browser",
                "language_user",
                "language_system",
                "os",
                "screen_resolution",
                "screen_orientation",
                "client_resolution",
                "timezone_offset",
                "user_agent",
                "plugins",
                "referer_url",
                "origin_url",
                "links_to_documents",
                "media_id",
            )
        ),
    );

    /**
     * Analyzes SequenceID
     *
     * @param string $sequenceId
     * @return string[]
     */
    public function analyzeSequenceId($sequenceId)
    {
        if (!is_string($sequenceId)) {
            return array('SequenceID is not a string');
        }
        $len = strlen($sequenceId);
        if ($len < 6 || $len > 40) {
            return array(sprintf(
                'Invalid SequenceID length. It must be in range [6, 40], but %d received.',
                $len
            ));
        }

        return array();
    }

    /**
     * Analyzes identities from envelope
     *
     * @param IdentityNodeInterface[] $identities
     * @return string[]
     */
    public function analyzeIdentities(array $identities)
    {
        $detail = array();
        if (count($identities) > 0) {
            foreach ($identities as $i => $identity) {
                if (!$identity instanceof IdentityNodeInterface) {
                    $detail[] = $i . '-th elements of Identities not implements IdentityNodeInterface';
                }
            }
        }

        return $detail;
    }

    /**
     * Analyzes envelope type and mandatory fields
     *
     * @param EnvelopeInterface $envelope
     * @return string[]
     */
    public function analyzeTypeAndMandatoryFields(EnvelopeInterface $envelope)
    {
        $type = $envelope->getType();
        if (!is_string($type)) {
            return array('Envelope type must be string');
        } elseif (!isset(self::$types[$type])) {
            return array(
                sprintf('Envelope type "%s" not supported by this client version', $type)
            );
        } else {
            $details = array();
            $typeInfo = self::$types[$type];

            // Mandatory fields check
            foreach ($typeInfo['mandatory'] as $name) {
                if (!isset($envelope[$name]) || empty($envelope[$name])) {
                    $details[] = sprintf(
                        'Field "%s" is mandatory for "%s", but not provided',
                        $name,
                        $type
                    );
                }
            }

            // Field presence check
            $fields = array_merge($typeInfo['mandatory'], $typeInfo['optional'], self::$sharedOptional);
            foreach ($envelope as $key => $value) {
                if (!$this->isCustom($key) && !in_array($key, $fields)) {
                    $details[] = sprintf('Field "%s" not found in "%s"', $key, $envelope->getType());
                }
            }

            return $details;
        }
    }

    /**
     * Analyzes field types
     *
     * @param EnvelopeInterface $envelope
     * @return array
     */
    public function analyzeFieldTypes(EnvelopeInterface $envelope)
    {
        $type = $envelope->getType();
        if (is_string($type) && isset(self::$types[$type])) {
            $details = array();

            // Per field check
            foreach ($envelope as $key => $value) {
                // Is custom?
                if ($this->isCustom($key)) {
                    if (!is_string($value)) {
                        $details[] = sprintf(
                            'All custom values must be string, but for "%s" %s was provided',
                            $key,
                            $value === null ? 'null' : gettype($value)
                        );
                    }
                } elseif (isset(self::$dataTypes[$key])) {
                    // Checking type
                    if (preg_match('/string\((\d+)\)/', self::$dataTypes[$key], $matches)) {
                        if (!is_string($value)) {
                            $details[] = sprintf(
                                'Field "%s" must be string, but %s provided',
                                $key,
                                $value === null ? 'null' : gettype($value)
                            );
                        } elseif (strlen($value) > (int)$matches[1]) {
                            $details[] = sprintf(
                                'Received %d bytes of %s allowed for string key "%s" - value is too long',
                                strlen($value),
                                $matches[1],
                                $key
                            );
                        }
                    } else {
                        switch (self::$dataTypes[$key]) {
                            case 'int':
                                if (!is_int($value)) {
                                    $details[] = sprintf(
                                        'Field "%s" must be int, but %s provided',
                                        $key,
                                        $value === null ? 'null' : gettype($value)
                                    );
                                }
                                break;
                            case 'float':
                                if (!is_float($value) && !is_int($value)) {
                                    $details[] = sprintf(
                                        'Field "%s" must be float/double, but %s provided',
                                        $key,
                                        $value === null ? 'null' : gettype($value)
                                    );
                                }
                                break;
                            case 'bool':
                                if (!is_bool($value)) {
                                    $details[] = sprintf(
                                        'Field "%s" must be boolean, but %s provided',
                                        $key,
                                        $value === null ? 'null' : gettype($value)
                                    );
                                }
                                break;
                            case 'array':
                                if (!is_array($value)) {
                                    $details[] = sprintf(
                                        'Field "%s" must be array, but %s provided',
                                        $key,
                                        $value === null ? 'null' : gettype($value)
                                    );
                                }
                                break;
                            default:
                                $details[] = sprintf('Unknown type for "%s"', $key);
                        }
                    }
                } else {
                    $details[] = sprintf('Unknown type for "%s"', $key);
                }
            }

            return $details;
        }

        return array();
    }

    /**
     * Checks envelope validity and throws an exception on error
     *
     * @param EnvelopeInterface $envelope
     * @throws EnvelopeValidationException
     */
    public function validate(EnvelopeInterface $envelope)
    {
        if ($envelope->getType() === 'postback') {
            $details = array_merge(
                $this->analyzeTypeAndMandatoryFields($envelope),
                $this->analyzeFieldTypes($envelope)
            );
        } elseif ($envelope->getType() === 'kyc_proof') {
            $details = array_merge(
                $this->analyzeTypeAndMandatoryFields($envelope),
                $this->analyzeFieldTypes($envelope)
            );
        } elseif ($envelope->getType() === Builder::EVENT_PROFILE_UPDATE) {
            $details = array_merge(
                $this->analyzeTypeAndMandatoryFields($envelope),
                $this->analyzeFieldTypes($envelope)
            );
        } else {
            $details = array_merge(
                $this->analyzeSequenceId($envelope->getSequenceId()),
                $this->analyzeIdentities($envelope->getIdentities()),
                $this->analyzeTypeAndMandatoryFields($envelope),
                $this->analyzeFieldTypes($envelope)
            );
        }

        if (count($details) > 0) {
            throw new EnvelopeValidationException($details);
        }
    }

    /**
     * Returns true if provided key belongs to custom fields family
     *
     * @param string $key
     * @return bool
     */
    public function isCustom($key)
    {
        return is_string($key) && strlen($key) >= 7 && substr($key, 0, 7) === 'custom_';
    }
}
