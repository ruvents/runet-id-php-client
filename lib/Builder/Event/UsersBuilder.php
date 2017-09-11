<?php

namespace RunetId\ApiClient\Builder\Event;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\SetMaxResultsTrait;

/**
 * @method \RunetId\ApiClient\Result\Event\Users getResult()
 */
class UsersBuilder extends AbstractEndpointBuilder
{
    use SetMaxResultsTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Event\Users',
        'endpoint' => '/event/users',
        'method' => 'GET',
        'paginated_data_offset' => 'Users',
    ];
}
