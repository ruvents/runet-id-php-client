<?php

namespace RunetId\ApiClient\Model\Connection;

class Place
{
    /**
     * @var int
     */
    public $Id;

    /**
     * @var string
     */
    public $Name;

    /**
     * @var bool
     */
    public $Reservation;

    /**
     * @var int
     */
    public $ReservationTime;

    /**
     * @var int
     */
    public $ReservationLimit;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Name;
    }
}
