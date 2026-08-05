<?php

namespace Covery\Client;

/**
 * Reusable optional-value type assertions for result DTOs.
 *
 * Each method is a no-op for "empty" values (null, '', 0, false) and throws an
 * InvalidArgumentException only when a non-empty value has the wrong type.
 */
class Validation
{
    /**
     * @param mixed $value
     * @param string $message
     * @throws \InvalidArgumentException
     */
    public static function optionalString($value, $message)
    {
        if (!empty($value) && !is_string($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     * @param string $message
     * @throws \InvalidArgumentException
     */
    public static function optionalInt($value, $message)
    {
        if (!empty($value) && !is_int($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     * @param string $message
     * @throws \InvalidArgumentException
     */
    public static function optionalBool($value, $message)
    {
        if (!empty($value) && !is_bool($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     * @param string $message
     * @throws \InvalidArgumentException
     */
    public static function optionalNumber($value, $message)
    {
        if (!empty($value) && !is_int($value) && !is_float($value)) {
            throw new \InvalidArgumentException($message);
        }
    }

    /**
     * @param mixed $value
     * @param string $message
     * @throws \InvalidArgumentException
     */
    public static function optionalArray($value, $message)
    {
        if (!empty($value) && !is_array($value)) {
            throw new \InvalidArgumentException($message);
        }
    }
}
