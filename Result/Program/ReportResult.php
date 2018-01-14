<?php

namespace RunetId\Client\Result\Program;

use RunetId\Client\Result\AbstractResult;
use RunetId\Client\Result\Company\CompanyResult;
use RunetId\Client\Result\User\UserResult;

/**
 * @property int                $Id
 * @property null|UserResult    $User
 * @property null|CompanyResult $Company
 * @property null|string        $CustomText
 * @property int                $SectionRoleId
 * @property string             $SectionRoleTitle
 * @property int                $Order
 * @property string             $Title
 * @property string             $Thesis
 * @property string             $FullInfo
 * @property string             $Url
 * @property string             $VideoUrl
 * @property string             $UpdateTime
 * @property bool               $Deleted
 */
final class ReportResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'User' => UserResult::class,
            'Company' => CompanyResult::class,
        ];
    }
}
