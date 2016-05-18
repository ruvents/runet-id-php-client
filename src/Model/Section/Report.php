<?php

namespace RunetId\ApiClient\Model\Section;

use RunetId\ApiClient\Model\User;

/**
 * Section report
 */
class Report
{
    const ROLE_ORGANIZER = 1;

    const ROLE_HOST = 2;

    const ROLE_REPORTER = 3;

    const ROLE_ORGANIZER_HOST = 4;

    const ROLE_ROUND_TABLE = 5;

    /**
     * @var int
     */
    public $Id;

    /**
     * @var User
     */
    public $User;

    /**
     * @var int
     */
    public $SectionRoleId;

    /**
     * @var string
     */
    public $SectionRoleTitle;

    /**
     * @var int
     */
    public $Order;

    /**
     * @var string
     */
    public $Title;

    /**
     * @var string
     */
    public $Thesis;

    /**
     * @var string
     */
    public $FullInfo;

    /**
     * @var string
     */
    public $Url;

    /**
     * @var string
     */
    public $VideoUrl;

    /**
     * @var \DateTime
     */
    public $UpdateTime;

    /**
     * @var bool
     */
    public $Deleted;

    /**
     * @return array
     */
    public static function getRoles()
    {
        return [
            self::ROLE_ORGANIZER,
            self::ROLE_HOST,
            self::ROLE_REPORTER,
            self::ROLE_ORGANIZER_HOST,
            self::ROLE_ROUND_TABLE,
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Title;
    }

    /**
     * @return bool
     */
    public function isRoleHost()
    {
        return in_array($this->SectionRoleId, [
            self::ROLE_HOST,
            self::ROLE_ORGANIZER_HOST,
        ]);
    }

    /**
     * @return bool
     */
    public function isRoleOrganizer()
    {
        return in_array($this->SectionRoleId, [
            self::ROLE_ORGANIZER,
            self::ROLE_ORGANIZER_HOST,
        ]);
    }

    /**
     * @return bool
     */
    public function isRoleReporter()
    {
        return $this->SectionRoleId == self::ROLE_REPORTER;
    }

    /**
     * @return bool
     */
    public function isRoleRoundTable()
    {
        return $this->SectionRoleId == self::ROLE_ROUND_TABLE;
    }
}
