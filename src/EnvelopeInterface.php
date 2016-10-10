<?php

namespace Covery\Client;

/**
 * Interface EnvelopeInterface
 *
 * EnvelopeInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface EnvelopeInterface extends \IteratorAggregate, \ArrayAccess
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getSequenceId();

    /**
     * @return IdentityNodeInterface[]
     */
    public function getIdentities();

    /**
     * @return array
     */
    public function toArray();
}
