<?php

namespace Covery\Client\MediaConnection;

use Covery\Client\MediaConnectionInterface;

class MediaConnection implements MediaConnectionInterface
{
    /**
     * @var int
     */
    private $requestId;

    /**
     * @var array
     */
    private $mediaId;

    /**
     * @var array
     */
    private $data;

    /**
     * MediaConnection constructor.
     */
    public function __construct($requestId, $mediaId = [], $data = [])
    {
        if (!is_int($requestId)) {
            throw new \InvalidArgumentException('Request Id must be string');
        }
        if (!is_array($mediaId)) {
            throw new \InvalidArgumentException('Media Id must be array');
        }

        $this->requestId = $requestId;
        $this->mediaId = $mediaId;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \OutOfBoundsException("No offset {$offset}");
        }

        return $this->data[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * @return int
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @return array
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }
}
