<?php

namespace RunetId\ApiClient\Result\Company;

use Ruvents\AbstractApiClient\Result\AbstractResult;

/**
 * @property CompanyResult[] $Companies
 * @property null|string     $NextPageToken
 */
class ListResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Companies' => 'RunetId\ApiClient\Result\Company\CompanyResult[]',
        ];
    }
}
