<?php

namespace RunetId\ApiClient\Exception;

use Ruvents\AbstractApiClient\Common\ContextRequestTrait;
use Ruvents\AbstractApiClient\Common\ContextResponseTrait;
use Ruvents\AbstractApiClient\Common\ContextTrait;

class JsonDecodeException extends \RuntimeException implements ExceptionInterface
{
    use ContextTrait;
    use ContextRequestTrait;
    use ContextResponseTrait;

    public function __construct($message, array $context, \Exception $previous = null)
    {
        $this->context = $context;

        parent::__construct($message, 0, $previous);
    }
}
