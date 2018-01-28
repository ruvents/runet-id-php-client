<?php

namespace RunetId\Client\Endpoint;

abstract class AbstractDeleteEndpoint extends AbstractEndpoint
{
    use SuccessResultTrait;

    protected $method = 'DELETE';
}
