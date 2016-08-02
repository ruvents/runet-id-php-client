<?php

namespace RunetId\ApiClient\Model\User;

/**
 * User status
 */
class Status
{
    const ROLE_PARTICIPANT = 1;

    const ROLE_MASS_MEDIA = 2;

    const ROLE_REPORTER = 3;

    const ROLE_PARTNER = 5;

    const ROLE_ORGANIZER = 6;

    const ROLE_VIDEO = 26;

    const ROLE_VIRTUAL = 24;

    /**
     * @var int
     */
    public $RoleId;

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
            self::ROLE_VIRTUAL,
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->RoleTitle;
    }

    /**
     * @return bool
     */
    public function isParticipant()
    {
        return $this->RoleId == self::ROLE_PARTICIPANT;
    }

    /**
     * @return bool
     */
    public function isMassMedia()
    {
        return $this->RoleId == self::ROLE_MASS_MEDIA;
    }

    /**
     * @return bool
     */
    public function isReporter()
    {
        return $this->RoleId == self::ROLE_REPORTER;
    }

    /**
     * @return bool
     */
    public function isPartner()
    {
        return $this->RoleId == self::ROLE_PARTNER;
    }

    /**
     * @return bool
     */
    public function isOrganizer()
    {
        return $this->RoleId == self::ROLE_ORGANIZER;
    }

    /**
     * @return bool
     */
    public function isVideo()
    {
        return $this->RoleId == self::ROLE_VIDEO;
    }

    /**
     * @return bool
     */
    public function isVirtual()
    {
        return $this->RoleId == self::ROLE_VIRTUAL;
    }
}
