<?php

namespace Covery\Client;

/**
 * Interface MediaStorageInterface
 *
 * MediaStorageInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface MediaStorageInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
