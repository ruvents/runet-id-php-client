<?php

namespace RunetId\Client\Endpoint\Company;

use RunetId\Client\Endpoint\AbstractPaginatedEndpoint;
use RunetId\Client\Result\Company\ListResult;

/**
 * @method $this setCode(string $code)
 * @method $this setQuery(string $query)
 * @method ListResult getResult()
 */
final class ListEndpoint extends AbstractPaginatedEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/company/list';
    }

    /**
     * {@inheritdoc}
     */
    protected function getOffset()
    {
        return 'Companies';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return ListResult::class;
    }
}
