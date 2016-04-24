<?php

namespace RunetId\ApiClient\Model\Section;

use RunetId\ApiClient\Model\User;

/**
 * Class Report
 */
class Report
{
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
}
