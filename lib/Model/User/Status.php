<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Model\Event\RoleIdInterface;
use RunetId\ApiClient\Model\AbstractModel;

/**
 * @property int         $RoleId
 * @property null|string $RoleTitle
 * @property null|string $UpdateTime
 * @property null|string $TicketUrl
 * @property null|bool   $Registered
 */
class Status extends AbstractModel implements RoleIdInterface
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
