<?php

namespace Covery\Client\Envelopes;

use Covery\Client\EnvelopeInterface;
use Covery\Client\EnvelopeValidationException;

class ValidatorV1
{
    private static $dataTypes = array(
        'billing_address' => 'string',
        'billing_city' => 'string',
        'billing_country' => 'string',
        'billing_firstname' => 'string',
        'billing_lastname' => 'string',
        'billing_fullname' => 'string',
        'billing_state' => 'string',
        'billing_zip' => 'string',
        'card_id' => 'string',
        'card_last4' => 'string',
        'country' => 'string',
        'cpu_class' => 'string',
        'device_fingerprint' => 'string',
        'firstname' => 'string',
        'gender' => 'string',
        'language' => 'string',
        'language_browser' => 'string',
        'language_system' => 'string',
        'language_user' => 'string',
        'languages' => 'string',
        'lastname' => 'string',
        'login_user_agent' => 'string',
        'os' => 'string',
        'payment_method' => 'string',
        'payment_mid' => 'string',
        'payment_system' => 'string',
        'product_description' => 'string',
        'product_name' => 'string',
        'registration_useragent' => 'string',
        'screen_orientation' => 'string',
        'screen_resolution' => 'string',
        'social_type' => 'string',
        'transaction_currency' => 'string',
        'transaction_id' => 'string',
        'transaction_mode' => 'string',
        'transaction_type' => 'string',
        'user_agent' => 'string',
        'user_merchant_id' => 'string',
        'user_name' => 'string',
        'website_url' => 'string',
        'transaction_source' => 'string',
        'ip' => 'string',
        'merchant_ip' => 'string',
        'real_ip' => 'string',
        'email' => 'string',
        'phone' => 'string',
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
    );

    private static $types = array(
        'confirmation' => array(
            'mandatory' => array('confirmation_timestamp', 'user_merchant_id'),
            'optional' => array('email_confirmed', 'phone_confirmed'),
        ),
        'login' => array(
            'mandatory' => array('login_timestamp', 'user_merchant_id'),
            'optional' => array('email', 'login_failed', 'phone')
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
            ),
        ),
        'transaction' => array(
            'mandatory' => array(
                'transaction_amount',
                'transaction_currency',
                'transaction_id',
                'transaction_mode',
                'transaction_timestamp',
                'transaction_type',
                'card_bin',
                'card_id',
                'card_last4',
                'expiration_month',
                'expiration_year',
                'user_merchant_id',
            ),
            'optional' => array(
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
            )
        ),
    );

    /**
     * Checks envelope validity and throws an exception on error
     *
     * @param EnvelopeInterface $envelope
     * @throws EnvelopeValidationException
     */
    public function validate(EnvelopeInterface $envelope)
    {
        $details = [];

        // Checking sequenceId
        if (strlen($envelope->getSequenceId()) < 6 || strlen($envelope->getSequenceId()) > 40) {
            $details[] = sprintf(
                'Invalid SequenceID length. It must be in range [6, 40], but %d received.',
                strlen($envelope->getSequenceId())
            );
        }

        // Checking identity nodes
        if (count($envelope->getIdentities()) === 0) {
            $details[] = 'At least one Identity must be supplied';
        }

        // Checking envelope type
        if (!isset(self::$types[$envelope->getType()])) {
            $details[] = sprintf('Envelope type "%s" not supported by this client version', $envelope->getType());
        } else {
            $typeInfo = self::$types[$envelope->getType()];
            // Mandatory fields check
            foreach ($typeInfo['mandatory'] as $name) {
                if (!isset($envelope[$name]) || empty($envelope[$name])) {
                    $details[] = sprintf(
                        'Field "%s" is mandatory for "%s", but not provided',
                        $name,
                        $envelope->getType()
                    );
                }
            }

            // Per field check
            $fields = array_merge($typeInfo['mandatory'], $typeInfo['optional']);
            $customCount = 0;
            foreach ($envelope as $key => $value) {
                // Is custom?
                if (strlen($key) >= 7 && substr($key, 0, 7) === 'custom_') {
                    $customCount++;
                    if (!is_string($value)) {
                        $details[] = sprintf(
                            'All custom values must be string, but for "%s" %s was provided',
                            $key,
                            $value === null ? 'null' : gettype($value)
                        );
                    }
                } else {
                    if (!in_array($key, $fields)) {
                        $details[] = sprintf('Field "%s" not found in "%s"', $key, $envelope->getType());
                    } else {
                        // Checking type
                        switch (self::$dataTypes[$key]) {
                            case 'string':
                                if (!is_string($value)) {
                                    $details[] = sprintf(
                                        'Field "%s" must be string, but %s provided',
                                        $key,
                                        $value === null ? 'null' : gettype($value)
                                    );
                                }
                                break;
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
                }
            }
        }

        if (count($details) > 0) {
            throw new EnvelopeValidationException($details);
        }
    }
}
