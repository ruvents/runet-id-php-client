<?php

namespace RunetId\Client\Endpoint\Competence;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Competence\TestResult;

/**
 * @method TestResult[] getResult()
 */
final class TestsEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/competence/tests';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return TestResult::class.'[]';
    }
}
