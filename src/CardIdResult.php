<?php

namespace Covery\Client;

/**
 * Class CardIdResult
 *
 * Contains cardId result data, received from Covery
 *
 * @package Covery\Client
 */
class CardIdResult
{
    /**
     * @var string
     */
    private $requestId;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var double
     */
    private $createdAt;

    /**
     * CardIdResult constructor.
     *
     * @param string $requestId
     * @param string $cardId
     * @param float $createdAt
     */
    public function __construct(
        $requestId,
        $cardId,
        $createdAt
    ) {
        if (!is_string($requestId)) {
            throw new \InvalidArgumentException("Request ID must be string");
        }

        if (!is_string($cardId)) {
            throw new \InvalidArgumentException("Card Id must be string");
        }

        if (!is_double($createdAt)) {
            throw new \InvalidArgumentException("Created At must be double");
        }

        $this->requestId = $requestId;
        $this->cardId = $cardId;
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return string
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * @return double
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
