<?php

namespace RunetId\ApiClient\Result\User;

use RunetId\ApiClient\ArgumentHelper\EventRoleIdInterface;
use RunetId\ApiClient\Result\AbstractResult;

/**
 * @property int         $RoleId
 * @property null|string $RoleTitle
 * @property null|int    $RolePriority
 * @property null|string $UpdateTime
 * @property null|string $TicketUrl
 * @property null|bool   $Registered
 */
class StatusResult extends AbstractResult implements EventRoleIdInterface
{
    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->RoleTitle;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->RoleId;
    }
}
