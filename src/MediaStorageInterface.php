<?php

namespace Covery\Client;

/**
 * Interface MediaStorageInterface
 *
 * MediaStorageInterface represents data packet, sent to Covery
 *
 * @package Covery\Client
 */
interface MediaStorageInterface extends \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @return string
     */
    public function getContentType();

    /**
     * @return string
     */
    public function getContentDescription();

    /**
     * @return @sting
     */
    public function getFileName();

    /**
     * @return @bool
     */
    public function getOCR();

    /**
     * @return array
     */
    public function toArray();
}
