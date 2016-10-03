<?php

namespace RunetId\ApiClient\Model\Connection;

use RunetId\ApiClient\Model\User;

class Response
{
    const STATUS_AWAITING = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = 2;
    const STATUS_CANCELLED = 3;

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
