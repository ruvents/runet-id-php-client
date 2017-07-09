<?php

namespace RunetId\ApiClient\Exception;

use Ruvents\AbstractApiClient\Common\ContextRequestTrait;
use Ruvents\AbstractApiClient\Common\ContextResponseTrait;
use Ruvents\AbstractApiClient\Common\ContextTrait;

class ApiErrorException extends \RuntimeException implements ExceptionInterface
{
    use ContextTrait;
    use ContextRequestTrait;
    use ContextResponseTrait;

    public function __construct($message, $code, array $context, \Exception $previous = null)
    {
        $this->context = $context;

        parent::__construct($message, $code, $previous);
    }
}
