<?php

namespace RunetId\Client\Test\Fixtures\Endpoint;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Endpoint\SuccessResultTrait;

final class SuccessTestEndpoint extends AbstractEndpoint
{
    use SuccessResultTrait;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/test';
    }
}
