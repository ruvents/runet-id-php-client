<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\User\AddressResult;

/**
 * @method $this         setRunetId(int $runetId)
 * @method AddressResult getResult()
 */
final class AddressEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/address';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return AddressResult::class;
    }
}
