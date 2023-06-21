<?php

namespace Covery\Client;

/**
 * Interface MediaConnectionInterface
 *
 * MediaConnectionInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface MediaConnectionInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
