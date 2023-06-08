<?php

namespace Covery\Client;

/**
 * Interface MediaConnectionInterface
 *
 * MediaConnectionInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface MediaConnectionInterface extends \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @return string
     */
    public function getRequestId();

    /**
     * @return array
     */
    public function getMediaId();

    /**
     * @return array
     */
    public function toArray();
}
