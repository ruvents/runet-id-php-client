<?php

namespace RunetId\ApiClient\Result\User;

use RunetId\ApiClient\Common\UserRunetIdInterface;
use RunetId\ApiClient\Result\AbstractResult;

/**
 * @property int               $RunetId
 * @property null|string       $CreationTime
 * @property null|bool         $Visible
 * @property null|bool         $Verified
 * @property null|string       $Gender
 * @property null|string       $LastName
 * @property null|string       $FirstName
 * @property null|string       $FatherName
 * @property null|PhotoResult  $Photo
 * @property null|array        $Attributes
 * @property null|WorkResult   $Work
 * @property null|StatusResult $Status
 * @property null|string       $Email
 * @property null|string       $Phone
 * @property null|string       $PhoneFormatted
 * @property null|array        $Phones
 */
class UserResult extends AbstractResult implements UserRunetIdInterface
{
    /**
     * @return string
     */
    public function __toString()
    {
        return trim($this->FirstName.' '.$this->LastName);
    }

    /**
     * {@inheritdoc}
     */
    public function getRunetId()
    {
        return $this->RunetId;
    }

    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Photo' => 'RunetId\ApiClient\Result\User\PhotoResult',
            'Status' => 'RunetId\ApiClient\Result\User\StatusResult',
            'Work' => 'RunetId\ApiClient\Result\User\WorkResult',
        ];
    }
}
