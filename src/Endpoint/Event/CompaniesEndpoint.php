<?php

namespace RunetId\Client\Endpoint\Event;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Company\CompanyResult;

/**
 * @method CompanyResult[] getResult()
 */
final class CompaniesEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/event/companies';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return CompanyResult::class.'[]';
    }
}
