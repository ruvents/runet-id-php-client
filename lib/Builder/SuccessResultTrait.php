<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\Result\Success;

trait SuccessResultTrait
{
    use ObjectResultTrait;

    /**
     * {@inheritdoc}
     */
    protected function getResultClass()
    {
        return Success::className();
    }
}
