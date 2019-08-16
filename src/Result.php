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
     * @var string
     */
    private $type;
    /**
     * @var int
     */
    private $createdAt;
    /**
     * @var string
     */
    private $sequenceId;
    /**
     * @var string
     */
    private $merchantUserId;
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
     * @var null|string
     */
    private $reason;
    /**
     * @var null|string
     */
    private $action;
    /**
     * @var null|array
     */
    private $customResponse;

    /**
     * Result constructor.
     *
     * @param int $requestId
     * @param string $type
     * @param int $createdAt
     * @param string $sequenceId
     * @param string $merchantUserId
     * @param int $score
     * @param bool $accept
     * @param bool $reject
     * @param bool $manual
     * @param null|string $reason
     * @param null|string $action
     * @param null|array $customResponse
     */
    public function __construct(
        $requestId,
        $type,
        $createdAt,
        $sequenceId,
        $merchantUserId,
        $score,
        $accept,
        $reject,
        $manual,
        $reason = null,
        $action = null,
        $customResponse = null
    ) {
        if (!is_int($requestId)) {
            throw new \InvalidArgumentException('Request ID must be integer');
        }
        if (!is_string($type)) {
            throw new \InvalidArgumentException('Type must be string');
        }
        if (!is_int($createdAt)) {
            throw new \InvalidArgumentException('Created At must be integer');
        }
        if (!is_string($sequenceId)) {
            throw new \InvalidArgumentException('Sequence Id must be string');
        }
        if (!is_string($merchantUserId)) {
            throw new \InvalidArgumentException('Merchant User Id must be string');
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
        if ($reason !== null && !is_string($reason)) {
            throw new \InvalidArgumentException('Reason must be string');
        }
        if ($action !== null && !is_string($action)) {
            throw new \InvalidArgumentException('Action must be string');
        }
        if ($customResponse !== null && !is_array($customResponse)) {
            throw new \InvalidArgumentException('Custom Response must be array');
        }
        $this->requestId = $requestId;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->sequenceId = $sequenceId;
        $this->merchantUserId = $merchantUserId;
        $this->score = $score;
        $this->accept = $accept;
        $this->reject = $reject;
        $this->manual = $manual;
        $this->reason = $reason;
        $this->action = $action;
        $this->customResponse = $customResponse;
    }

    /**
     * @return int
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    /**
     * @return string
     */
    public function getMerchantUserId()
    {
        return $this->merchantUserId;
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

    /**
     * @return string|null
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return string|null
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return array|null
     */
    public function getCustomResponse()
    {
        return $this->customResponse;
    }
}
