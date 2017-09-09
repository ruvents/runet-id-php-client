<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\Model\User\User;

/**
 * @method $this setToken(string $token)
 *
 * @method User getResult()
 */
class UserAuthBuilder extends AbstractEndpointBuilder
{
    /**
     * @var array
     */
    public $context = [
        'endpoint' => '/user/auth',
        'method' => 'GET',
    ];

    /**
     * {@inheritdoc}
     */
    protected function getResultClass()
    {
        return 'RunetId\ApiClient\Model\User\User';
    }
}
