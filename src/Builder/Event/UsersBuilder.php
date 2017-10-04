<?php

namespace RunetId\ApiClient\Builder\Event;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Builder\SetMaxResultsTrait;

/**
 * @method \RunetId\ApiClient\Result\Event\UsersResult getResult()
 */
class UsersBuilder extends AbstractBuilder
{
    use SetMaxResultsTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Event\UsersResult',
        'endpoint' => '/event/users',
        'method' => 'GET',
        'paginated_data_offset' => 'Users',
    ];
}
