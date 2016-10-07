<?php

namespace RunetId\ApiClient\Model;

use DateInterval;
use DateTime;
use RunetId\ApiClient\Model\Connection\Place;
use RunetId\ApiClient\Model\Connection\Response;
use Ruvents\DataReconstructor\DataReconstructor;
use Ruvents\DataReconstructor\ReconstructableInterface;

class Connection implements ReconstructableInterface
{
    const TYPE_PERSONAL = 1;
    const TYPE_GROUP = 2;

    const STATUS_OPEN = 1;
    const STATUS_CANCELLED = 2;

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
     * @var Response[]
     */
    public $Users;

    /**
     * @var int
     */
    public $UserCount;

    /**
     * @var DateTime
     */
    public $Start;

    /**
     * @var DateTime
     */
    public $End;

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
     * @var int
     */
    public $Status;

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
        $this->Start = new DateTime($data['Start']);
        $this->End = (new DateTime($data['Start']))
            ->add(new DateInterval('PT20M'));

        $users = [];

        foreach ($data['Users'] as $response) {
            $users[$response['User']['RunetId']] = $response;
        }

        $data['Users'] = $users;
        unset($data['Start']);
    }
}
