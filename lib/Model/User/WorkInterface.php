<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Model\Company\CompanyInterface;

interface WorkInterface
{
    /**
     * @return string|null
     */
    public function getPosition();

    /**
     * @return CompanyInterface|null
     */
    public function getCompany();

    /**
     * @return \DateTimeInterface|null
     */
    public function getStart();

    /**
     * @return \DateTimeInterface|null
     */
    public function getEnd();
}
