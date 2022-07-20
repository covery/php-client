<?php

namespace Covery\Client;

/**
 * Class CardIdValidationException
 *
 * Special exception class, thrown when cardId validation failed
 *
 * @package Covery\Client
 */
class CardIdValidationException extends Exception
{
    /**
     * @var string[]
     */
    private $details;

    /**
     * CardIdValidationException constructor.
     *
     * @param string[] $details
     */
    public function __construct(array $details)
    {
        if (count($details) === 0) {
            parent::__construct('CardId validation failed');
            $details = [];
        } elseif (count($details) === 1) {
            parent::__construct($details[0]);
        } else {
            parent::__construct(
                sprintf(
                    'CardId validation failed. %d asserts failed',
                    count($details)
                )
            );
        }

        $this->details = $details;
    }

    /**
     * @return string[]
     */
    public function getDetails()
    {
        return $this->details;
    }
}
