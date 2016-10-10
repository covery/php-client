<?php

namespace Covery\Client\Identities;

/**
 * Class Stub
 *
 * Stub identity is used for cases, when no other identity can be applied
 *
 * @package Covery\Client\Identities
 */
class Stub extends AbstractIdentityNode
{
    /**
     * Stub constructor.
     */
    public function __construct()
    {
        parent::__construct('gateId', 1);
    }
}
