<?php

namespace RunetId\ApiClient\Exception;

use Exception;
use Ruvents\HttpClient\Response\Response;

/**
 * Class ResponseException
 */
class ResponseException extends ApiException implements ApiExceptionInterface
{
    /**
     * @var null|Response
     */
    private $response;

    /**
     * {@inheritdoc}
     * @param null|Response $response
     */
    public function __construct($message = '', $code = 0, Exception $previous = null, Response $response = null)
    {
        $this->response = $response;
    }

    /**
     * @return null|Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
