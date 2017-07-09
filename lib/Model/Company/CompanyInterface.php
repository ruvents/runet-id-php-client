<?php

namespace RunetId\ApiClient\Model\Company;

interface CompanyInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();
}
