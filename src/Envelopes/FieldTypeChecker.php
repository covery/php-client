<?php

namespace Covery\Client\Envelopes;

/**
 * Validates individual envelope field values against the ValidatorV1 schema.
 *
 * Extracted from ValidatorV1 to keep the validator focused on envelope-level
 * checks; this collaborator owns the per-field type checking.
 */
class FieldTypeChecker
{
    /**
     * Validates a single envelope field value against its expected type.
     *
     * @param string $key
     * @param mixed $value
     * @return string[] List of validation error messages (empty when valid)
     */
    public function analyze($key, $value)
    {
        if ($this->isCustom($key)) {
            return $this->analyzeCustomFieldValue($key, $value);
        }
        if (!isset(ValidatorV1Schema::$dataTypes[$key])) {
            return array(sprintf('Unknown type for "%s"', $key));
        }
        if (preg_match('/string\((\d+)\)/', ValidatorV1Schema::$dataTypes[$key], $matches)) {
            return $this->analyzeStringFieldValue($key, $value, (int)$matches[1]);
        }

        return $this->analyzeTypedFieldValue($key, $value, ValidatorV1Schema::$dataTypes[$key]);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return string[]
     */
    private function analyzeCustomFieldValue($key, $value)
    {
        if (!is_string($value)) {
            return array(sprintf(
                'All custom values must be string, but for "%s" %s was provided',
                $key,
                $value === null ? 'null' : gettype($value)
            ));
        }

        return array();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $maxLength
     * @return string[]
     */
    private function analyzeStringFieldValue($key, $value, $maxLength)
    {
        if (!is_string($value)) {
            return array(sprintf(
                'Field "%s" must be string, but %s provided',
                $key,
                $value === null ? 'null' : gettype($value)
            ));
        }
        if (strlen($value) > $maxLength) {
            return array(sprintf(
                'Received %d bytes of %s allowed for string key "%s" - value is too long',
                strlen($value),
                $maxLength,
                $key
            ));
        }

        return array();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string $dataType
     * @return string[]
     */
    private function analyzeTypedFieldValue($key, $value, $dataType)
    {
        switch ($dataType) {
            case 'int':
                if (!is_int($value)) {
                    return array($this->typeMismatch($key, 'int', $value));
                }
                return array();
            case 'float':
                if (!is_float($value) && !is_int($value)) {
                    return array($this->typeMismatch($key, 'float/double', $value));
                }
                return array();
            case 'bool':
                if (!is_bool($value)) {
                    return array($this->typeMismatch($key, 'boolean', $value));
                }
                return array();
            case 'array_int':
                return $this->analyzeArrayFieldValue($key, $value, 'int');
            case 'array_string':
                return $this->analyzeArrayFieldValue($key, $value, 'string');
            default:
                return array(sprintf('Unknown type for "%s"', $key));
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param string $itemType 'int' or 'string'
     * @return string[]
     */
    private function analyzeArrayFieldValue($key, $value, $itemType)
    {
        $details = array();
        if (!is_array($value)) {
            $details[] = sprintf(
                'Field "%s" must be array, but %s provided',
                $key,
                $value === null ? 'null' : gettype($value)
            );

            return $details;
        }

        foreach ($value as $id) {
            $invalid = $itemType === 'int' ? (!is_int($id) || $id <= 0) : !is_string($id);
            if ($invalid) {
                $details[] = sprintf(
                    'ID: "%s" must be %s, but %s provided',
                    $id,
                    $itemType,
                    $id === null ? 'null' : gettype($id)
                );
            }
        }

        return $details;
    }

    /**
     * @param string $key
     * @param string $expectedType
     * @param mixed $value
     * @return string
     */
    private function typeMismatch($key, $expectedType, $value)
    {
        return sprintf(
            'Field "%s" must be %s, but %s provided',
            $key,
            $expectedType,
            $value === null ? 'null' : gettype($value)
        );
    }

    /**
     * Returns true if provided key belongs to custom fields family
     *
     * @param string $key
     * @return bool
     */
    private function isCustom($key)
    {
        return is_string($key) && strlen($key) >= 7 && substr($key, 0, 7) === 'custom_';
    }
}
