<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\Model\Common\Address;
use RunetId\ApiClient\Model\User\UserRunetIdInterface;

/**
 * @method Address getResult()
 */
class UserAddressBuilder extends AbstractEndpointBuilder
{
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
        return 'RunetId\ApiClient\Model\Common\Address';
    }
}
