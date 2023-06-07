<?php

namespace Covery\Client;

/**
 * Class MediaStorageResult
 *
 * Contains MediaStorage result data, received from Covery
 *
 * @package Covery\Client
 */
class MediaStorageResult
{
    /**
     * @var string
     */
    private $uploadUrl;

    /**
     * @var int
     */
    private $mediaId;

    /**
     * @var float
     */
    private $createdAt;

    /**
     * MediaStorageResult constructor.
     *
     * @param string $uploadUrl
     * @param int $mediaId
     * @param float $createdAt
     */
    public function __construct(
        $uploadUrl,
        $mediaId,
        $createdAt
    ) {
        if (!is_string($uploadUrl)) {
            throw new \InvalidArgumentException("Upload URL must be string");
        }

        if (!is_int($mediaId)) {
            throw new \InvalidArgumentException("Media Id must be int");
        }

        if (!is_double($createdAt)) {
            throw new \InvalidArgumentException("Created At must be float");
        }

        $this->uploadUrl = $uploadUrl;
        $this->mediaId = $mediaId;
        $this->createdAt = $createdAt;
    }


    /**
     * @return string
     */
    public function getUploadUrl()
    {
        return $this->uploadUrl;
    }

    /**
     * @return int
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * @return float
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
