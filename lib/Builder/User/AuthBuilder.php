<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;

/**
 * @method \RunetId\ApiClient\Result\User\User getResult()
 */
class AuthBuilder extends AbstractEndpointBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\User',
        'endpoint' => '/user/auth',
        'method' => 'GET',
    ];

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        return $this->setParam('token', $token);
    }
}
