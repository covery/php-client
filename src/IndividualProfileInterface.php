<?php

namespace Covery\Client;

/**
 * Interface IndividualProfileInterface
 *
 * IndividualProfileInterface represents client management individual
 * profile data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface IndividualProfileInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
