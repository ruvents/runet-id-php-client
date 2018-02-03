<?php

namespace RunetId\Client\Endpoint\Pay;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Pay\ListResult;

/**
 * @method $this      setPayerRunetId(int $payerRunetId)
 * @method ListResult getResult()
 */
final class ListEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/pay/list';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return ListResult::class;
    }
}
