<?php

namespace RunetId\Client\Endpoint\Pay;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Pay\FilterListItemResult;

/**
 * @method $this                  setManager(string $manager)
 * @method $this                  setParams(array $params)
 * @method $this                  setFilter(array $filter)
 * @method FilterListItemResult[] getResult()
 */
final class FilterListEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/pay/filterList';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return FilterListItemResult::class.'[]';
    }
}
