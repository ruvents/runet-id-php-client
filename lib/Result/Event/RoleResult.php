<?php

namespace RunetId\ApiClient\Result\Event;

use RunetId\ApiClient\ArgumentHelper\EventRoleIdInterface;
use Ruvents\AbstractApiClient\Result\AbstractResult;

/**
 * @property int         $RoleId
 * @property null|string $Name
 * @property null|int    $Priority
 */
class RoleResult extends AbstractResult implements EventRoleIdInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->RoleId;
    }
}
