<?php

namespace Covery\Client\Envelopes;

use Covery\Client\EnvelopeInterface;
use Covery\Client\IdentityNodeInterface;

class Envelope implements EnvelopeInterface
{
    /**
     * @var string
     */
    private $sequenceId;
    /**
     * @var string
     */
    private $type;
    /**
     * @var array
     */
    private $data;
    /**
     * @var IdentityNodeInterface[]
     */
    private $inodes;

    /**
     * Envelope constructor.
     * @param string $type
     * @param string $sequenceId
     * @param IdentityNodeInterface[] $inodes
     * @param array $values
     */
    public function __construct($type, $sequenceId, array $inodes, array $values)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException('Envelope type must be string');
        }
        if (!is_string($sequenceId)) {
            throw new \InvalidArgumentException('Sequence ID must be string');
        }
        foreach ($inodes as $node) {
            if (!$node instanceof IdentityNodeInterface) {
                throw new \InvalidArgumentException('Array of IdentityNode expected');
            }
        }

        $this->type = $type;
        $this->sequenceId = $sequenceId;
        $this->inodes = $inodes;
        $this->data = $values;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function getSequenceId()
    {
        return $this->sequenceId;
    }

    /**
     * @inheritDoc
     */
    public function getIdentities()
    {
        return $this->inodes;
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
    public function count()
    {
        return count($this->data);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->data;
    }
}
