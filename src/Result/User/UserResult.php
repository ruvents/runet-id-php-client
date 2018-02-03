<?php

namespace RunetId\Client\Result\User;

use RunetId\Client\Result\AbstractResult;

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
final class UserResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Photo' => PhotoResult::class,
            'Status' => StatusResult::class,
            'Work' => WorkResult::class,
        ];
    }
}
