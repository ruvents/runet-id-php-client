<?php

namespace RunetId\ApiClient\Model;

use RunetId\ApiClient\Model\User\Photo;
use RunetId\ApiClient\Model\User\Status;
use RunetId\ApiClient\Model\User\Work;

/**
 * Class User
 */
class User
{
    /**
     * @var int
     */
    public $RunetId;

    /**
     * @var string
     */
    public $FirstName;

    /**
     * @var string
     */
    public $LastName;

    /**
     * @var string
     */
    public $FatherName;

    /**
     * @var \DateTime
     */
    public $CreationTime;

    /**
     * @var bool
     */
    public $Visible;

    /**
     * @var bool
     */
    public $Verified;

    /**
     * @var string
     */
    public $Gender;

    /**
     * @var Photo
     */
    public $Photo;

    /**
     * @var Work
     */
    public $Work;

    /**
     * @var Status
     */
    public $Status;

    /**
     * @var string
     */
    public $Email;

    /**
     * @var string
     */
    public $Phone;

    /**
     * @var string
     */
    public $PhoneFormatted;

    /**
     * @var array
     */
    public $Phones;
}
