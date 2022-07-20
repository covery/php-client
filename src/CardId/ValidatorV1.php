<?php

namespace Covery\Client\CardId;

use Covery\Client\CardIdInterface;
use Covery\Client\CardIdValidationException;

class ValidatorV1
{
    private static $dataTypes = array(
        'card_number' => 'string(20)',
    );

    private static $types = array(
        'card_id' => array(
            'mandatory' => array(
                'card_number',
            ),
            'optional' => array()
        ),
    );

    /**
     * Checks cardId validity and throws an exception on error
     *
     * @param CardIdInterface $cardId
     * @return void
     * @throws CardIdValidationException
     */
    public function validate(CardIdInterface $cardId)
    {
        $details = array_merge(
            $this->analyzeTypeAndMandatoryFields($cardId),
            $this->analyzeFieldTypes($cardId)
        );

        if (count($details) > 0) {
            throw new CardIdValidationException($details);
        }
    }

    /**
     * Analyzes cardId type and mandatory fields
     *
     * @param CardIdInterface $cardId
     * @return string[]
     */
    public function analyzeTypeAndMandatoryFields(CardIdInterface $cardId)
    {
        $type = $cardId->getType();
        if (!is_string($type)) {
            return array('CardId type must be string');
        } elseif (!isset(self::$types[$type])) {
            return array(
                sprintf('CardId type "%s" not supported by this client version', $type)
            );
        } else {
            $details = array();
            $typeInfo = self::$types[$type];

            // Mandatory fields check
            foreach ($typeInfo['mandatory'] as $name) {
                if (!isset($cardId[$name]) || empty($cardId[$name])) {
                    $details[] = sprintf(
                        'Field "%s" is mandatory for "%s", but not provided',
                        $name,
                        $type
                    );
                }
            }

            return $details;
        }
    }

    /**
     * Analyzes field types
     *
     * @param CardIdInterface $cardId
     * @return array
     */
    public function analyzeFieldTypes(CardIdInterface $cardId)
    {
        $type = $cardId->getType();
        if (is_string($type) && isset(self::$types[$type])) {
            $details = array();

            // Per field check
            foreach ($cardId as $key => $value) {
                if (isset(self::$dataTypes[$key])) {
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
}
