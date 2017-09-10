<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\ObjectResultTrait;
use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Result\User\Address;
use RunetId\ApiClient\Result\User\UserRunetIdInterface;

/**
 * @method Address getResult()
 */
class AddressBuilder extends AbstractEndpointBuilder
{
    use ObjectResultTrait;

    /**
     * @var array
     */
    public $context = [
        'endpoint' => '/user/address',
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
     * {@inheritdoc}
     */
    protected function getResultClass()
    {
        return 'RunetId\ApiClient\Model\User\Address';
    }
}
