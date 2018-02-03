<?php

namespace RunetId\Client\Endpoint\Section;

use RunetId\Client\Endpoint\AbstractDeleteEndpoint;

/**
 * @method $this setRunetId(string $runetId)
 * @method $this setSectionId(string $sectionId)
 */
final class DeleteFavoriteEndpoint extends AbstractDeleteEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/section/deleteFavorite';
    }
}
