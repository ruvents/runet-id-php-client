<?php

namespace RunetId\Client\Exception;

final class RunetIdException extends \RuntimeException
{
    private $data;

    public function __construct($invalidString = [])
    {
        $this->data = $invalidString;

        parent::__construct(
            isset($invalidString['Error']['Message']) ? $invalidString['Error']['Message'] : '',
            isset($invalidString['Error']['Code']) ? (int) $invalidString['Error']['Code'] : 0
        );
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
