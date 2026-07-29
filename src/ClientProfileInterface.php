<?php

namespace Covery\Client;

/**
 * Interface ClientProfileInterface
 *
 * ClientProfileInterface represents client management client profile
 * request data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface ClientProfileInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
