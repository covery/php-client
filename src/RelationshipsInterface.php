<?php

namespace Covery\Client;

/**
 * Interface RelationshipsInterface
 *
 * RelationshipsInterface represents client management relationships
 * data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface RelationshipsInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
