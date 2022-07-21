<?php

namespace Covery\Client;

/**
 * Interface CardIdInterface
 *
 * CardIdInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface CardIdInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
