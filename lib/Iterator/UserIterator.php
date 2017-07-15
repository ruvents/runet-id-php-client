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
    protected function denormalize(array $rawData)
    {
        return $this->denormalizer->denormalize($rawData['Users'], 'RunetId\ApiClient\Model\User\User[]');
    }
}
