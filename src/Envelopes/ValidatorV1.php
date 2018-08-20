<?php

namespace Covery\Client\Envelopes;

use Covery\Client\EnvelopeInterface;
use Covery\Client\EnvelopeValidationException;
use Covery\Client\IdentityNodeInterface;

class ValidatorV1
{
    private static $dataTypes = array(
        'billing_address' => 'string(255)',
        'billing_city' => 'string(50)',
        'billing_country' => 'string(60)',
        'billing_firstname' => 'string(50)',
        'billing_lastname' => 'string(50)',
        'billing_fullname' => 'string(100)',
        'billing_state' => 'string(50)',
        'billing_zip' => 'string(10)',
        'card_id' => 'string(255)',
        'card_last4' => 'string(4)',
        'country' => 'string(60)',
        'cpu_class' => 'string(255)',
        'device_fingerprint' => 'string(255)',
        'device_id' => 'string(255)',
        'firstname' => 'string(50)',
        'gender' => 'string(10)',
        'language' => 'string(12)',
        'language_browser' => 'string(12)',
        'language_system' => 'string(12)',
        'language_user' => 'string(12)',
        'languages' => 'string(255)',
        'lastname' => 'string(50)',
        'os' => 'string(255)',
        'payment_method' => 'string(255)',
        'payment_mid' => 'string(255)',
        'payment_system' => 'string(255)',
        'payment_account_id' => 'string(255)',
        'product_description' => 'string(1024)',
        'product_name' => 'string(255)',
        'screen_orientation' => 'string(45)',
        'screen_resolution' => 'string(32)',
        'social_type' => 'string(50)',
        'birth_date' => 'int',
        'fullname' => 'string(100)',
        'state' => 'string(50)',
        'city' => 'string(50)',
        'address' => 'string(255)',
        'zip' => 'string(10)',
        'transaction_currency' => 'string(10)',
        'transaction_id' => 'string(255)',
        'transaction_mode' => 'string(255)',
        'transaction_type' => 'string(32)',
        'user_agent' => 'string(1024)',
        'local_ip_list' => 'string(1024)',
        'plugins' => 'string(1024)',
        'refererUrl' => 'string(255)',
        'originUrl' => 'string(255)',
        'clientResolution' => 'string(255)',
        'user_merchant_id' => 'string(45)',
        'user_name' => 'string(255)',
        'website_url' => 'string(255)',
        'transaction_source' => 'string(255)',
        'ip' => 'string(45)',
        'merchant_ip' => 'string(45)',
        'real_ip' => 'string(45)',
        'email' => 'string(255)',
        'phone' => 'string(15)',
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
        'payout_currency' => 'string(10)',
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
        'refund_currency' => 'string(10)',
        'refund_amount_converted' => 'float',
        'refund_source' => 'string(255)',
        'refund_type' => 'string(32)',
        'refund_code' => 'string(32)',
        'refund_reason' => 'string(255)',
        'refund_method' => 'string(255)',
        'refund_system' => 'string(255)',
        'refund_mid' => 'string(255)',
        'event_id' => 'string(255)',
        'event_timestamp' => 'int',
        'amount' => 'float',
        'amount_converted' => 'float',
        'currency' => 'string(10)',
        'account_id' => 'string(255)',
        'account_system' => 'string(255)',
        'method' => 'string(255)',
        'second_account_id' => 'string(255)',
        'operation' => 'string(60)',
        'second_email' => 'string(255)',
        'second_phone' => 'string(15)',
        'second_birth_date' => 'int',
        'second_firstname' => 'string(50)',
        'second_lastname' => 'string(50)',
        'second_fullname' => 'string(100)',
        'second_state' => 'string(50)',
        'second_city' => 'string(50)',
        'second_address' => 'string(255)',
        'second_zip' => 'string(10)',
        'second_gender' => 'string(10)',
        'second_country' => 'string(60)',
        'agent_id' => 'string(255)',
        'transaction_status' => 'string(100)',
        'code' => 'string(100)',
        'reason' => 'string(100)',
        'secure3d' => 'string(100)',
        'avs_result' => 'string(100)',
        'cvv_result' => 'string(100)',
        'psp_code' => 'string(100)',
        'psp_reason' => 'string(100)',
        'arn' => 'string(255)',
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
        'refererUrl',
        'originUrl',
        'clientResolution'
    );

    private static $types = array(
        'confirmation' => array(
            'mandatory' => array('confirmation_timestamp', 'user_merchant_id'),
            'optional' => array('email_confirmed', 'phone_confirmed', 'email', 'phone'),
        ),
        'login' => array(
            'mandatory' => array('login_timestamp', 'user_merchant_id'),
            'optional' => array('email', 'login_failed', 'phone', 'gender', 'traffic_source', 'affiliate_id')
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
                'payout_expiration_year'
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
                'user_merchant_id'
            )
        ),
        'transfer' => array(
            'mandatory' => array(
                'event_id',
                'event_timestamp',
                'amount',
                'currency',
                'account_id',
                'second_account_id',
                'account_system',
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
            )
        ),
        'postback' => array(
            'mandatory' => array(),
            'optional' => array(
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
        )
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
            $customCount = 0;
            foreach ($envelope as $key => $value) {
                if ($this->isCustom($key)) {
                    $customCount++;
                } elseif (!in_array($key, $fields)) {
                    $details[] = sprintf('Field "%s" not found in "%s"', $key, $envelope->getType());
                }
            }

            if ($customCount > 10) {
                $details[] = sprintf('Expected 10 or less custom fields, but %d provided', $customCount);
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
        $details = array_merge(
            $this->analyzeSequenceId($envelope->getSequenceId()),
            $this->analyzeIdentities($envelope->getIdentities()),
            $this->analyzeTypeAndMandatoryFields($envelope),
            $this->analyzeFieldTypes($envelope)
        );

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
