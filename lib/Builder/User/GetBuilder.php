<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Builder\SetRunetIdTrait;

/**
 * @method $this setEmail(string $email)
 *
 * @method \RunetId\ApiClient\Result\User\UserResult getResult()
 */
class GetBuilder extends AbstractBuilder
{
    use SetRunetIdTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\UserResult',
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

        return $this->setParam('Builders', $builders);
    }
}
