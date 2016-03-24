<?php

namespace RunetId\ApiClient\Model\User;

/**
 * Class Status
 * @package RunetId\ApiClient\Model\User
 */
class Status
{
    /**
     * @var int
     */
    public $RoleId;

    /**
     * @var string
     */
    public $RoleName;

    /**
     * @var string
     */
    public $RoleTitle;

    /**
     * @var \DateTime
     */
    public $UpdateTime;

    /**
     * @var string
     */
    public $TicketUrl;

    /**
     * @var bool
     */
    public $Registered;
}
