<?php

namespace RunetId\ApiClient\Model\Company;

use RunetId\ApiClient\Model\AbstractModel;

/**
 * @property int         $Id
 * @property null|string $Name
 */
class Company extends AbstractModel implements CompanyIdInterface
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
