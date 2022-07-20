<?php

namespace Covery\Client\CardId;

use Covery\Client\CardIdInterface;

class CardId implements CardIdInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $data;

    /**
     * CardId constructor.
     * @param string $type
     */
    public function __construct($type, array $data)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException('CardId type must be string');
        }

        $this->type = $type;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}
