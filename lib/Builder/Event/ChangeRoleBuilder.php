<?php

namespace RunetId\ApiClient\Builder\Event;

use RunetId\ApiClient\ArgumentHelper\ArgumentHelper;
use RunetId\ApiClient\ArgumentHelper\EventRoleIdInterface;
use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Builder\SetRunetIdTrait;

/**
 * @method \RunetId\ApiClient\Result\SuccessResult getResult()
 */
class ChangeRoleBuilder extends AbstractBuilder
{
    use SetRunetIdTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\SuccessResult',
        'endpoint' => '/event/changeRole',
        'method' => 'POST',
    ];

    /**
     * @param int|EventRoleIdInterface $roleId
     *
     * @return $this
     */
    public function setRoleId($roleId)
    {
        return $this->setParam('RoleId', ArgumentHelper::getEventRoleId($roleId));
    }
}
