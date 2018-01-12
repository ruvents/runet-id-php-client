<?php

namespace RunetId\Client\Exception;

final class RunetIdException extends \RuntimeException implements ExceptionInterface
{
    private $data;

    public function __construct($data = [])
    {
        $this->data = $data;

        parent::__construct(
            isset($data['Error']['Message']) ? $data['Error']['Message'] : '',
            isset($data['Error']['Code']) ? (int) $data['Error']['Code'] : 0
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
