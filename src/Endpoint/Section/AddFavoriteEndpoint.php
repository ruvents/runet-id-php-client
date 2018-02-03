<?php

namespace RunetId\Client\Endpoint\Section;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Endpoint\SuccessResultTrait;

/**
 * @method $this setRunetId(string $runetId)
 * @method $this setSectionId(string $sectionId)
 */
final class AddFavoriteEndpoint extends AbstractPostEndpoint
{
    use SuccessResultTrait;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/section/addFavorite';
    }
}
