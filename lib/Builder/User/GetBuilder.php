<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\ObjectResultTrait;
use RunetId\ApiClient\Builder\SetRunetIdTrait;
use RunetId\ApiClient\Result\User\User;

/**
 * @method $this setEmail(string $email)
 *
 * @method User getResult()
 */
class GetBuilder extends AbstractEndpointBuilder
{
    use ObjectResultTrait;
    use SetRunetIdTrait;

    /**
     * @var array
     */
    public $context = [
        'endpoint' => '/user/get',
        'method' => 'GET',
    ];

    /**
     * @param string|string[] $builders
     *
     * @return $this
     */
    public function setBuilders($builders)
    {
        if (is_array($builders)) {
            $builders = implode(',', $builders);
        }

        return $this->setQueryParam('Builders', $builders);
    }

    /**
     * {@inheritdoc}
     */
    protected function getResultClass()
    {
        return User::className();
    }
}
