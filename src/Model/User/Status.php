<?php

namespace RunetId\ApiClient\Model\User;

/**
 * Class Status
 */
class Status
{
    const ROLE_PARTICIPANT = 1;

    const ROLE_MASS_MEDIA = 2;

    const ROLE_REPORTER = 3;

    const ROLE_PARTNER = 5;

    const ROLE_ORGANIZER = 6;

    const ROLE_VIDEO = 26;

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

    /**
     * @return array
     */
    public static function getRoles()
    {
        return [
            self::ROLE_PARTICIPANT,
            self::ROLE_MASS_MEDIA,
            self::ROLE_REPORTER,
            self::ROLE_PARTNER,
            self::ROLE_ORGANIZER,
            self::ROLE_VIDEO,
        ];
    }
}
