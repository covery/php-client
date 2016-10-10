<?php

namespace Covery\Client;

/**
 * Class EnvelopeValidationException
 *
 * Special exception class, thrown when envelope validation failed
 *
 * @package Covery\Client
 */
class EnvelopeValidationException extends Exception
{
    /**
     * @var string[]
     */
    private $details;

    /**
     * EnvelopeValidationException constructor.
     *
     * @param string[] $details
     */
    public function __construct(array $details)
    {
        if (count($details) === 0) {
            parent::__construct('Envelope validation failed');
            $details = [];
        } elseif (count($details) === 1) {
            parent::__construct($details[0]);
        } else {
            parent::__construct(
                sprintf(
                    'Envelope validation failed. %d asserts failed',
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
