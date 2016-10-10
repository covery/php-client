<?php

namespace Covery\Client;

/**
 * Interface IdentityNode
 *
 * Identity node is special Covery entity, used to determine
 * envelope ownership.
 *
 * @package Covery\Client
 */
interface IdentityNode
{
    /**
     * Returns Identity type
     *
     * @return string
     */
    public function getType();

    /**
     * Returns Identity id
     *
     * @return int
     */
    public function getId();
}
