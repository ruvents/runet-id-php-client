<?php

namespace RunetId\Client\Result\User;

use RunetId\Client\Result\AbstractResult;

/**
 * @property UserResult[] $Users
 * @property null|string  $NextPageToken
 */
final class SearchResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Users' => UserResult::class.'[]',
        ];
    }
}
