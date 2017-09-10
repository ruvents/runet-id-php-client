<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\ModelResultTrait;
use RunetId\ApiClient\Model\User\User;

/**
 * @method User getResult()
 */
class AuthBuilder extends AbstractEndpointBuilder
{
    use ModelResultTrait;

    /**
     * @var array
     */
    public $context = [
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
        return $this->setQueryParam('token', $token);
    }

    /**
     * {@inheritdoc}
     */
    protected function getResultClass()
    {
        return 'RunetId\ApiClient\Model\User\User';
    }
}
