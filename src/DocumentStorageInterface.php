<?php

namespace Covery\Client;

/**
 * Interface DocumentStorageInterface
 *
 * DocumentStorageInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface DocumentStorageInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
