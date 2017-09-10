<?php

namespace RunetId\ApiClient\Builder;

trait SuccessResultTrait
{
    use ObjectResultTrait;

    /**
     * {@inheritdoc}
     */
    protected function getResultClass()
    {
        return 'RunetId\ApiClient\Result\Success';
    }
}
