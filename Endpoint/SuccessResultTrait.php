<?php

namespace RunetId\Client\Endpoint;

use RunetId\Client\Result\SuccessResult;

/**
 * @internal
 *
 * @method SuccessResult getResult()
 */
trait SuccessResultTrait
{
    /**
     * @see AbstractEndpoint::getClass()
     *
     * @return string
     */
    protected function getClass()
    {
        return SuccessResult::class;
    }
}
