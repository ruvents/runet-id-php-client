<?php

namespace RunetId\ApiClient\Builder\Event;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method $this setFromUpdateTime(string $fromUpdateTime)
 * @method $this setWithDeleted(bool $withDeleted)
 *
 * @method \RunetId\ApiClient\Result\Program\HallResult[] getResult()
 */
class HallsBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Program\HallResult[]',
        'endpoint' => '/event/halls',
        'method' => 'GET',
    ];
}
