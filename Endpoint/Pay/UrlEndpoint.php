<?php

namespace RunetId\Client\Endpoint\Pay;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Pay\UrlResult;

/**
 * @method $this setPayerRunetId(int $payerRunetId)
 * @method UrlResult getResult()
 */
final class UrlEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/pay/url';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return UrlResult::class;
    }
}
