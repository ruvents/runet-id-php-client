<?php

namespace RunetId\ApiClient\Iterator;

use RunetId\ApiClient\Model\User\User;

/**
 * @method User current()
 */
class UserIterator extends AbstractIterator
{
    /**
     * {@inheritdoc}
     */
    protected function extractData(array $rawData)
    {
        return $rawData['Users'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getDenormalizationClass()
    {
        return 'RunetId\ApiClient\Model\User\User[]';
    }
}
