<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\ObjectResultTrait;
use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Result\User\User;
use RunetId\ApiClient\Result\User\UserRunetIdInterface;

/**
 * @method $this setEmail(string $email)
 *
 * @method User getResult()
 */
class GetBuilder extends AbstractEndpointBuilder
{
    use ObjectResultTrait;

    /**
     * @var array
     */
    public $context = [
        'endpoint' => '/user/get',
        'method' => 'GET',
    ];

    /**
     * @param int|UserRunetIdInterface $runetId
     *
     * @return $this
     */
    public function setRunetId($runetId)
    {
        return $this->setQueryParam('RunetId', ArgHelper::getUserRunetId($runetId));
    }

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
        return 'RunetId\ApiClient\Model\User\User';
    }
}
