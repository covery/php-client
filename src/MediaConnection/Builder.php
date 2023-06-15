<?php

namespace Covery\Client\MediaConnection;

class Builder
{
    /**
     * @var array
     */
    private $data = [];

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
        if (!is_int($requestId) && $requestId < 0) {
            throw new \InvalidArgumentException('Request Id must be positive integer');
        }
        if (!is_array($mediaId)) {
            throw new \InvalidArgumentException('Media Id must be array');
        }
        if (!$this->isListOfPositiveInt($mediaId)) {
            throw new \InvalidArgumentException('Media Id must be list of positive int');
        }

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

    /**
     * @param array $ids
     * @return bool
     */
    private function isListOfPositiveInt(array $ids)
    {
        foreach ($ids as $id) {
            if (!is_int($id) || $id < 0) {
                return false;
            }
        }

        return true;
    }
}
