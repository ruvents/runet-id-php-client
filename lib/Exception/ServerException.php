<?php

namespace RunetId\ApiClient\Exception;

use Ruvents\AbstractApiClient\Common\ContextRequestTrait;
use Ruvents\AbstractApiClient\Common\ContextResponseTrait;
use Ruvents\AbstractApiClient\Common\ContextTrait;

class ServerException extends \RuntimeException implements ExceptionInterface
{
    use ContextTrait;
    use ContextRequestTrait;
    use ContextResponseTrait;

    public function __construct(array $context, \Exception $previous = null)
    {
        $this->context = $context;

        parent::__construct(
            sprintf('Server responded with %d status code.', $code = $this->getResponse()->getStatusCode()),
            $code, $previous
        );
    }
}
