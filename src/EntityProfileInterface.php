<?php

namespace Covery\Client;

/**
 * Interface EntityProfileInterface
 *
 * EntityProfileInterface represents client management entity
 * profile data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface EntityProfileInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
