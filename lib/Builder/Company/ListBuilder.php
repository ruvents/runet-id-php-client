<?php

namespace RunetId\ApiClient\Builder\Company;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method $this setCode(string $code)
 * @method $this setQuery(string $query)
 *
 * @method \RunetId\ApiClient\Result\Company\ListResult getResult()
 */
class ListBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Company\ListResult',
        'endpoint' => '/company/list',
        'method' => 'GET',
        'paginated_data_offset' => 'Companies',
    ];
}
