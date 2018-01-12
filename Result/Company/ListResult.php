<?php

namespace RunetId\Client\Result\Company;

use RunetId\Client\Result\AbstractResult;

/**
 * @property CompanyResult[] $Companies
 * @property null|string     $NextPageToken
 */
final class ListResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Companies' => CompanyResult::class.'[]',
        ];
    }
}
