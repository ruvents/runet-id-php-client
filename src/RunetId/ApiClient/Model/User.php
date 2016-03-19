<?php

namespace RunetId\ApiClient\Model;

use RunetId\ApiClient\Model\User\Company;
use RunetId\ApiClient\Model\User\Photo;
use RunetId\ApiClient\Model\User\Status;
use RunetId\ApiClient\Model\User\Work;

/**
 * Class User
 * @package RunetId\ApiClient\Model
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
     * @var
     */
    public $Email;

    /**
     * @var
     */
    public $Phone;

    /**
     * @var
     */
    public $PhoneFormatted;

    /**
     * @var
     */
    public $Phones;

    /**
     * @param string $CreationTime
     * @return $this
     */
    public function setCreationTime($CreationTime = null)
    {
        if (!isset($CreationTime)) {
            return $this;
        }

        $this->CreationTime = new \DateTime($CreationTime);

        return $this;
    }

    /**
     * @param $Photo
     * @return $this
     */
    public function setPhoto($Photo = null)
    {
        if (!isset($Photo)) {
            return $this;
        }

        $this->Photo = new Photo();

        foreach ($Photo as $property => $value) {
            $this->Photo->$property = $value;
        }

        return $this;
    }

    /**
     * @param $Work
     * @return $this
     */
    public function setWork($Work = null)
    {
        if (!isset($Work)) {
            return $this;
        }

        $this->Work = new Work();

        $this->Work->Position = $Work['Position'];
        $this->Work->Company = new Company();
        $this->Work->Company->Id = $Work['Company']['Id'];
        $this->Work->Company->Name = $Work['Company']['Name'];
        $this->Work->StartYear = $Work['StartYear'];
        $this->Work->StartMonth = $Work['StartMonth'];
        $this->Work->EndYear = $Work['EndYear'];
        $this->Work->EndMonth = $Work['EndMonth'];

        return $this;
    }

    /**
     * @param $Status
     * @return $this
     */
    public function setStatus($Status = null)
    {
        if (!isset($Status)) {
            return $this;
        }

        $this->Status = new Status();

        foreach ($Status as $property => $value) {
            if ($property === 'UpdateTime') {
                $value = new \DateTime($value);
            }

            $this->Status->$property = $value;
        }

        return $this;
    }
}
