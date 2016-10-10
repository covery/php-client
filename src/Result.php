<?php

namespace Covery\Client;

/**
 * Class Result
 *
 * Contains decision result data, received from Covery
 *
 * @package Covery\Client
 */
class Result
{
    /**
     * @var int
     */
    private $requestId;
    /**
     * @var int
     */
    private $score;
    /**
     * @var bool
     */
    private $accept;
    /**
     * @var bool
     */
    private $reject;
    /**
     * @var bool
     */
    private $manual;

    /**
     * Result constructor.
     *
     * @param int $requestId
     * @param int $score
     * @param bool $accept
     * @param bool $reject
     * @param bool $manual
     */
    public function __construct($requestId, $score, $accept, $reject, $manual)
    {
        if (!is_int($requestId)) {
            throw new \InvalidArgumentException('Request ID must be integer');
        }
        if (!is_int($score)) {
            throw new \InvalidArgumentException('Score must be integer');
        }
        if (!is_bool($accept)) {
            throw new \InvalidArgumentException('Accept flag must be boolean');
        }
        if (!is_bool($reject)) {
            throw new \InvalidArgumentException('Reject flag must be boolean');
        }
        if (!is_bool($manual)) {
            throw new \InvalidArgumentException('Manual flag must be boolean');
        }

        $this->requestId = $requestId;
        $this->score = $score;
        $this->accept = $accept;
        $this->reject = $reject;
        $this->manual = $manual;
    }

    /**
     * @return int
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return boolean
     */
    public function isAccept()
    {
        return $this->accept;
    }

    /**
     * @return boolean
     */
    public function isReject()
    {
        return $this->reject;
    }

    /**
     * @return boolean
     */
    public function isManual()
    {
        return $this->manual;
    }
}
