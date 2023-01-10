<?php

namespace Covery\Client;

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
     * @var int
     */
    private $createdAt;

    /**
     * MediaStorageResult constructor.
     *
     * @param $uploadUrl
     * @param $mediaId
     * @param $createdAt
     */
    public function __construct(
        $uploadUrl,
        $mediaId,
        $createdAt

    ) {
        if (!is_int($mediaId)) {
            throw new \InvalidArgumentException('media ID must be integer');
        }

        if (!is_string($uploadUrl)) {
            throw new \InvalidArgumentException('Upload Url must be string');
        }

        if (!is_int($createdAt)) {
            throw new \InvalidArgumentException('Created At must be integer');
        }

        $this->uploadUrl = $uploadUrl;
        $this->mediaId = $mediaId;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getMediaId()
    {
        return $this->mediaId;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
