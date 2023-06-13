<?php

namespace Covery\Client\MediaConnection;

class Builder
{
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var int
     */
    private $requestId;
    /**
     * @var array
     */
    private $mediaId;

    /**
     * Returns builder for media request
     *
     * @param $requestId
     * @param $mediaId
     * @return Builder
     */
    public static function mediaConnectionEvent($requestId, $mediaId)
    {
        $builder = new self();

        return $builder
            ->addConnectionData($requestId, $mediaId);
    }

    /**
     * Provides MediaConnection value
     *
     * @param $requestId
     * @param $mediaId
     * @return Builder
     */
    public function addConnectionData($requestId, $mediaId)
    {
        if (!is_int($requestId)) {
            throw new \InvalidArgumentException('Request Id must be integer');
        }
        if (!is_array($mediaId)) {
            throw new \InvalidArgumentException('Media Id must be array');
        }

        $this->requestId = $requestId;
        $this->mediaId = $mediaId;

        $this->replace('request_id', $requestId);
        $this->replace('media_id', $mediaId);

        return $this;
    }

    /**
     * Returns built MediaConnection
     *
     * @return MediaConnection
     */
    public function build()
    {
        return new MediaConnection(
            $this->requestId,
            $this->mediaId,
            array_filter($this->data, function ($data) {
                return $data !== null;
            })
        );
    }

    /**
     * Replaces value in internal array if provided value not empty
     *
     * @param string $key
     * @param string|int|float|bool|array|null $value
     */
    private function replace($key, $value)
    {
        if ($value !== null && $value !== '' && $value !== 0 && $value !== 0.0) {
            $this->data[$key] = $value;
        }
    }
}
