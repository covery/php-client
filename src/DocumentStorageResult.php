<?php

namespace Covery\Client;

/**
 * Class DocumentStorageResult
 *
 * Contains DocumentStorage result data, received from Covery
 *
 * @package Covery\Client
 */
class DocumentStorageResult
{
    /**
     * @var string
     */
    private $uploadUrl;

    /**
     * @var int
     */
    private $documentId;

    /**
     * @var float
     */
    private $createdAt;

    /**
     * DocumentStorageResult constructor.
     *
     * @param array $uploadUrl
     * @param int $documentId
     * @param int $createdAt
     */
    public function __construct(
        $uploadUrl,
        $documentId,
        $createdAt
    ) {
        if (!is_array($uploadUrl)) {
            throw new \InvalidArgumentException('Upload URL must be array');
        }

        foreach ($uploadUrl as $url) {
            if (!is_string($url)) {
                throw new \InvalidArgumentException('Upload URL must be list of int');
            }
        }
        if (!is_int($documentId)) {
            throw new \InvalidArgumentException("Document Id must be int");
        }

        if (!is_int($createdAt)) {
            throw new \InvalidArgumentException("Created At must be int");
        }

        $this->uploadUrl = $uploadUrl;
        $this->documentId = $documentId;
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
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * @return float
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
