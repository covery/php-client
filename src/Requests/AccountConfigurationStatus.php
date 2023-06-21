<?php

namespace Covery\Client\Requests;

use GuzzleHttp\Psr7\Request;

/**
 * Class Account Configuration Status
 *
 * Account Configuration Status data
 *
 * @package Covery\Client\Requests
 */
class AccountConfigurationStatus extends Request
{
    public function __construct()
    {
        // Building request
        parent::__construct(
            'GET',
            '/api/accountConfigurationStatus',
            []
        );
    }
}
