<?php

namespace RunetId\ApiClient\Model;

use DateTime;
use RunetId\ApiClient\Model\Connection\Place;
use Ruvents\DataReconstructor\DataReconstructor;
use Ruvents\DataReconstructor\ReconstructableInterface;

class Connection implements ReconstructableInterface
{
    /**
     * @var int
     */
    public $Id;

    /**
     * @var Place
     */
    public $Place;

    /**
     * @var User
     */
    public $Creator;

    /**
     * @var User[]
     */
    public $Users;

    /**
     * @var int
     */
    public $UserCount;

    /**
     * @var DateTime
     */
    public $Date;

    /**
     * @var int
     */
    public $Type;

    /**
     * @var string
     */
    public $Purpose;

    /**
     * @var string
     */
    public $Subject;

    /**
     * @var string
     */
    public $File;

    /**
     * @var DateTime
     */
    public $CreateTime;

    /**
     * @var int
     */
    public $ReservationNumber;

    /**
     * {@inheritdoc}
     */
    public function __construct(&$data, DataReconstructor $dataReconstructor, array $map)
    {
        $data['Date'] = $data['Date'].' '.$data['Time'];
        unset($data['Time']);
    }
}
