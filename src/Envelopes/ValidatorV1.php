<?php

namespace Covery\Client\Envelopes;

use Covery\Client\EnvelopeInterface;
use Covery\Client\EnvelopeValidationException;
use Covery\Client\IdentityNodeInterface;

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
     * @return string
     */
    public function analyzeIdentities(array $identities)
    {
        $detail = array();
        if (count($identities) === 0) {
            $detail[] = 'At least one Identity must be supplied';
        } else {
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
            $fields = array_merge($typeInfo['mandatory'], $typeInfo['optional']);
            $customCount = 0;
            foreach ($envelope as $key => $value) {
                if ($this->isCustom($type)) {
                    $customCount++;
                }
                if (!in_array($key, $fields)) {
                    $details[] = sprintf('Field "%s" not found in "%s"', $key, $envelope->getType());
                }
            }

            if ($customCount > 0) {
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
                    switch (self::$dataTypes[$key]) {
                        case 'string':
                            if (!is_string($value)) {
                                $details[] = sprintf(
                                    'Field "%s" must be string, but %s provided',
                                    $key,
                                    $value === null ? 'null' : gettype($value)
                                );
                            } elseif (strlen($value) > 255) {
                                $details[] = sprintf(
                                    'Received %d bytes to string key "%s" - value is too long',
                                    strlen($value),
                                    $key
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
