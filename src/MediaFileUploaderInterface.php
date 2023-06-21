<?php

namespace Covery\Client;

/**
 * Interface MediaFileUploaderInterface
 *
 * MediaFileUploaderInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface MediaFileUploaderInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}
