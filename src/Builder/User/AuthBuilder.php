<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method \RunetId\ApiClient\Result\User\UserResult getResult()
 */
class AuthBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\UserResult',
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
