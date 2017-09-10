<?php

namespace RunetId\ApiClient\Result\User;

use RunetId\ApiClient\Result\Event\RoleIdInterface;
use RunetId\ApiClient\Result\AbstractResult;

/**
 * @property int         $RoleId
 * @property null|string $RoleTitle
 * @property null|string $UpdateTime
 * @property null|string $TicketUrl
 * @property null|bool   $Registered
 */
class Status extends AbstractResult implements RoleIdInterface
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
