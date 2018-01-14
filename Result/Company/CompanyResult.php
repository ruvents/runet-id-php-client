<?php

namespace RunetId\Client\Result\Company;

use RunetId\Client\Result\AbstractResult;
use RunetId\Client\Result\User\UserResult;

/**
 * @property int          $Id
 * @property null|string  $Name
 * @property null|string  $FullName
 * @property null|string  $Info
 * @property null|string  $Logo
 * @property null|string  $Address
 * @property null|string  $AddressFormatted
 * @property null|int     $CountParticipants
 * @property null|string  $Email
 * @property null|int     $EmploymentsCount
 * @property UserResult[] $Employments
 * @property null|string  $OGRN
 * @property null|string  $Phone
 * @property null|string  $Site
 * @property null|array   $Attributes
 */
final class CompanyResult extends AbstractResult
{
}
