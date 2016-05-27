<?php

namespace RunetId\ApiClient\Model;

use RunetId\ApiClient\Exception\InvalidArgumentException;
use RunetId\ApiClient\Model\User\Photo;
use RunetId\ApiClient\Model\User\Status;
use RunetId\ApiClient\Model\User\Work;

/**
 * User
 */
class User
{
    const GENDER_MALE = 'male';

    const GENDER_FEMALE = 'female';

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

    /**
     * @param int $runetId
     * @return string
     * @throws InvalidArgumentException
     */
    public static function getUrlByRunetId($runetId)
    {
        if (!is_numeric($runetId)) {
            throw new InvalidArgumentException('The $runetId argument must be numeric.');
        }

        return 'http://runet-id.com/'.$runetId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return trim($this->FirstName.' '.$this->LastName);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return self::getUrlByRunetId($this->RunetId);
    }

    /**
     * @return bool
     */
    public function isMale()
    {
        return strtolower($this->Gender) === self::GENDER_MALE;
    }

    /**
     * @return bool
     */
    public function isFemale()
    {
        return !$this->isMale();
    }

    /**
     * @return bool
     */
    public function hasPhoto()
    {
        return !$this->Photo->isEmpty();
    }
}
