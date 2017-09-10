<?php

namespace RunetId\ApiClient\Result\Company;

use RunetId\ApiClient\Result\AbstractResult;

/**
 * @property int         $Id
 * @property null|string $Name
 */
class Company extends AbstractResult implements CompanyIdInterface
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
