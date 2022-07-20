<?php

namespace Covery\Client;

/**
 * Interface CardIdInterface
 *
 * CardIdInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface CardIdInterface extends \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return array
     */
    public function toArray();
}
