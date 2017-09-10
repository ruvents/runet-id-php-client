<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\ObjectResultTrait;
use RunetId\ApiClient\Result\User\User;

/**
 * @method User getResult()
 */
class AuthBuilder extends AbstractEndpointBuilder
{
    use ObjectResultTrait;

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
