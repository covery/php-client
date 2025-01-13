<?php

namespace Covery\Client\DocumentFileUploader;

use Covery\Client\DocumentFileUploaderInterface;

class DocumentFileUploader implements DocumentFileUploaderInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * DocumentConnection constructor.
     */
    public function __construct($data = [])
    {
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
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset): mixed
    {
        if (!$this->offsetExists($offset)) {
            throw new \OutOfBoundsException("No offset {$offset}");
        }

        return $this->data[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }
}
