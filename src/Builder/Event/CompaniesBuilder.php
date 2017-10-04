<?php

namespace RunetId\ApiClient\Builder\Event;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method \RunetId\ApiClient\Result\Company\CompanyResult[] getResult()
 */
class CompaniesBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Company\CompanyResult[]',
        'endpoint' => '/event/сompanies',
        'method' => 'GET',
    ];
}
