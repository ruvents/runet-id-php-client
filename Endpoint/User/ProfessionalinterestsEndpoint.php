<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\User\ProfessionalInterestResult;

/**
 * @method $this                        setRunetId(int $runetId)
 * @method ProfessionalInterestResult[] getResult()
 */
final class ProfessionalinterestsEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/professionalinterests';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return ProfessionalInterestResult::class.'[]';
    }
}
