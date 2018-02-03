<?php

namespace RunetId\Client\Endpoint\Section;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Program\FavoriteResult;

/**
 * @method $this            setRunetId(int $runetId)
 * @method $this            setFromUpdateTime(string $fromUpdateTime)
 * @method FavoriteResult[] getResult()
 */
final class FavoritesEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/section/favorites';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return FavoriteResult::class.'[]';
    }
}
