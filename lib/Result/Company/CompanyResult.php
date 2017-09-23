<?php

namespace RunetId\ApiClient\Result\Company;

use RunetId\ApiClient\ArgumentHelper\CompanyIdInterface;
use Ruvents\AbstractApiClient\Result\AbstractResult;

/**
 * @property int         $Id
 * @property null|string $Name
 * @property null|string $FullName
 * @property null|string $Info
 * @property null|string $Logo
 * @property null|array  $Attributes
 * @property null|int    $EmploymentsCount
 * @property null|string $Email
 * @property null|string $Phone
 * @property null|string $Site
 * @property null|string $OGRN
 * @property null|string $AddressFormatted
 * @property null|int    $CountParticipants
 */
class CompanyResult extends AbstractResult implements CompanyIdInterface
{
    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Name;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->Id;
    }
}
