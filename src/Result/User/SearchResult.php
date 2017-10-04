<?php

namespace RunetId\ApiClient\Result\User;

use Ruvents\AbstractApiClient\Result\AbstractResult;

/**
 * @property UserResult[] $Users
 * @property null|string  $NextPageToken
 */
class SearchResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Users' => 'RunetId\ApiClient\Result\User\UserResult[]',
        ];
    }
}
