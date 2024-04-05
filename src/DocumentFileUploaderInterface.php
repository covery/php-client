<?php

namespace Covery\Client;

/**
 * Interface DocumentFileUploaderInterface
 *
 * DocumentFileUploaderInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface DocumentFileUploaderInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
