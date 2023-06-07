<?php

namespace Covery\Client\MediaStorage;

use Covery\Client\MediaStorageInterface;

class MediaStorage implements MediaStorageInterface
{
    /**
     * @var bool
     */
    private $ocr;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $contentDescription;

    /**
     * @var array
     */
    private $data;

    /**
     * MediaStorage constructor.
     */
    public function __construct($contentType, $contentDescription, $fileName = '', $ocr = false, $data = [])
    {
        $contentTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
        ];
        $contentDescriptions = [
            'personal_photo',
            'linked_document',
            'general_document',
        ];
        if (!is_string($contentType)) {
            throw new \InvalidArgumentException('Content type must be string');
        }
        if (!in_array($contentType, $contentTypes)) {
            throw new \InvalidArgumentException('Content type must be one of the types: ' . implode(
                    ', ',
                    $contentTypes
                )
            );
        }
        if (!is_string($contentDescription)) {
            throw new \InvalidArgumentException('Content description must be string');
        }
        if (!in_array($contentDescription, $contentDescriptions)) {
            throw new \InvalidArgumentException('Content type must be one of the types: ' . implode(
                    ', ',
                    $contentDescriptions
                )
            );
        }
        if (!is_string($fileName)) {
            throw new \InvalidArgumentException('File name must be string');
        }
        if (!is_bool($ocr)) {
            throw new \InvalidArgumentException('OCR must be bool');
        }

        $this->contentType = $contentType;
        $this->contentDescription = $contentDescription;
        $this->fileName = $fileName;
        $this->ocr = $ocr;
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
     * @return string
     */
    public function getOcr()
    {
        return $this->ocr;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @return string
     */
    public function getContentDescription()
    {
        return $this->contentDescription;
    }
}
