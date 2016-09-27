<?php

namespace RunetId\ApiClient\Model\Connection;

use RunetId\ApiClient\Model\User;

class Response
{
    /**
     * @var int
     */
    public $Status;

    /**
     * @var string
     */
    public $Response;

    /**
     * @var User
     */
    public $User;
}
