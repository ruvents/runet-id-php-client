<?php

namespace RunetId\Client\Exception;

final class JsonDecodeException extends \RuntimeException implements ExceptionInterface
{
    private $invalidString;

    /**
     * @param string $invalidString
     */
    public function __construct($invalidString)
    {
        parent::__construct(json_last_error_msg(), json_last_error());
        $this->invalidString = $invalidString;
    }

    /**
     * @return string
     */
    public function getInvalidString()
    {
        return $this->invalidString;
    }
}
