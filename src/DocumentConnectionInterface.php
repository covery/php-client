<?php

namespace Covery\Client;

/**
 * Interface DocumentConnectionInterface
 *
 * DocumentConnectionInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface DocumentConnectionInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
