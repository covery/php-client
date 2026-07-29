<?php

namespace Covery\Client;

/**
 * Class IndividualProfileResult
 *
 * Contains individual profile result data, received from Covery
 *
 * @package Covery\Client
 */
class IndividualProfileResult implements \JsonSerializable
{
    /**
     * @var int
     */
    private $clientProfileId;

    /**
     * @var string
     */
    private $profileType;

    /**
     * @var int
     */
    private $createdAt;

    /**
     * IndividualProfileResult constructor.
     *
     * @param int $clientProfileId
     * @param string $profileType
     * @param int $createdAt
     */
    public function __construct(
        $clientProfileId,
        $profileType,
        $createdAt
    ) {
        if (!is_int($clientProfileId)) {
            throw new \InvalidArgumentException('Client profile id must be int');
        }

        if (!is_string($profileType)) {
            throw new \InvalidArgumentException('Profile type must be string');
        }

        if (!is_int($createdAt)) {
            throw new \InvalidArgumentException('Created At must be int');
        }

        $this->clientProfileId = $clientProfileId;
        $this->profileType = $profileType;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getClientProfileId()
    {
        return $this->clientProfileId;
    }

    /**
     * @return string
     */
    public function getProfileType()
    {
        return $this->profileType;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): mixed
    {
        return [
            'client_profile_id' => $this->clientProfileId,
            'profile_type'      => $this->profileType,
            'created_at'        => $this->createdAt,
        ];
    }
}
