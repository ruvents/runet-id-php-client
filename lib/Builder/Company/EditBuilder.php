<?php

namespace RunetId\ApiClient\Builder\Company;

use RunetId\ApiClient\ArgumentHelper\ArgumentHelper;
use RunetId\ApiClient\ArgumentHelper\CompanyIdInterface;
use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method $this setCode(string $code)
 * @method $this setName(string $name)
 * @method $this setFullName(string $fullName)
 * @method $this setInfo(string $info)
 * @method $this setFullInfo(string $fullInfo)
 * @method $this setContactAddress(array $contactAddress)
 * @method $this setAttributes(array $attributes)
 *
 * @method \RunetId\ApiClient\Result\SuccessResult getResult()
 */
class EditBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\SuccessResult',
        'endpoint' => '/company/edit',
        'method' => 'POST',
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
