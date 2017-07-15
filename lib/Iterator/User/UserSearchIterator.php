<?php

namespace RunetId\ApiClient\Iterator\User;

use RunetId\ApiClient\Iterator\AbstractIterator;
use RunetId\ApiClient\Model\User\User;

/**
 * @method User current()
 */
class UserSearchIterator extends AbstractIterator
{
    /**
     * {@inheritdoc}
     */
    protected function denormalize(array $rawData)
    {
        return $this->denormalizer->denormalize($rawData['Users'], 'RunetId\ApiClient\Model\User\User[]');
    }
}
