<?php

namespace RunetId\Client\Endpoint;

/**
 * @internal
 */
abstract class AbstractDeleteEndpoint extends AbstractEndpoint
{
    use SuccessResultTrait;

    protected $method = 'DELETE';
}
