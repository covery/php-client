<?php

namespace Covery\Client;

class MediaConnectionResult
{
    /**
     * @var int
     */
    private $requestId;

    /**
     * @var string|array
     */
    private $mediaId;

    /**
     * MediaConnectionResult constructor.
     *
     * @param $requestId
     * @param $mediaId
     */
    public function __construct(
        $requestId,
        $mediaId
    ) {
        if (!is_int($requestId)) {
            throw new \InvalidArgumentException('Request ID must be integer');
        }

        if (!is_int($mediaId) and !is_array($mediaId)) {
            throw new \InvalidArgumentException('media ID must be integer or array');
        }

        $this->requestId = $requestId;
        $this->mediaId = $mediaId;
    }

    /**
     * @return int
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return int|array
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }
}
