<?php

namespace RunetId\Client\Endpoint\Company;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Company\CompanyResult;

/**
 * @method $this         setCompanyId(int $companyId)
 * @method CompanyResult getResult()
 */
final class GetEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/company/get';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return CompanyResult::class;
    }
}
