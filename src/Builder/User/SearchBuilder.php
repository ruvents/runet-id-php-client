<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Builder\SetMaxResultsTrait;

/**
 * @method $this setQuery(string $query)
 *
 * @method \RunetId\ApiClient\Result\User\SearchResult getResult()
 */
class SearchBuilder extends AbstractBuilder
{
    use SetMaxResultsTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\SearchResult',
        'endpoint' => '/user/search',
        'method' => 'GET',
        'paginated_data_offset' => 'Users',
    ];
}
