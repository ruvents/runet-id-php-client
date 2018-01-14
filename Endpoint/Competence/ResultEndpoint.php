<?php

namespace RunetId\Client\Endpoint\Competence;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Competence\ResultResult;

/**
 * @method $this          setRunetId(int $runetId)
 * @method $this          setTestId(int $testId)
 * @method ResultResult[] getResult()
 */
final class ResultEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/competence/result';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return ResultResult::class.'[]';
    }
}
