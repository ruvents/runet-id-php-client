<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\SetMaxResultsTrait;

/**
 * @method $this setQuery(string $query)
 *
 * @method \RunetId\ApiClient\Result\User\Search getResult()
 */
class SearchBuilder extends AbstractEndpointBuilder
{
    use SetMaxResultsTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\Search',
        'endpoint' => '/user/search',
        'method' => 'GET',
        'paginated_data_offset' => 'Users',
    ];
}
