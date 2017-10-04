<?php

namespace RunetId\ApiClient\Builder\Company;

use RunetId\ApiClient\ArgumentHelper\ArgumentHelper;
use RunetId\ApiClient\ArgumentHelper\CompanyIdInterface;
use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method \RunetId\ApiClient\Result\Company\CompanyResult getResult()
 */
class GetBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Company\CompanyResult',
        'endpoint' => '/company/get',
        'method' => 'GET',
    ];

    /**
     * @param int|CompanyIdInterface $companyId
     *
     * @return $this
     */
    public function setCompanyId($companyId)
    {
        return $this->setParam('CompanyId', ArgumentHelper::getCompanyId($companyId));
    }
}
