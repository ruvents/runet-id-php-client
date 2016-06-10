<?php

namespace RunetId\ApiClient\Model;

use Ruvents\DataReconstructor\DataReconstructor;
use Ruvents\DataReconstructor\ReconstructableInterface;

/**
 * Event
 */
class Event implements ReconstructableInterface
{
    /**
     * @var int
     */
    public $Id;

    /**
     * @var string
     */
    public $IdName;

    /**
     * @var string
     */
    public $Title;

    /**
     * @var string
     */
    public $Info;

    /**
     * @var string
     */
    public $Place;

    /**
     * @var bool
     */
    public $Visible;

    /**
     * @var string
     */
    public $Url;

    /**
     * @var string
     */
    public $UrlRegistration;

    /**
     * @var string
     */
    public $UrlProgram;

    /**
     * @var \DateTime
     */
    public $Start;

    /**
     * @var int
     */
    public $StartYear;

    /**
     * @var int
     */
    public $StartMonth;

    /**
     * @var int
     */
    public $StartDay;

    /**
     * @var \DateTime
     */
    public $End;

    /**
     * @var int
     */
    public $EndYear;

    /**
     * @var int
     */
    public $EndMonth;

    /**
     * @var int
     */
    public $EndDay;

    /**
     * @var string
     */
    public $GeoPoint;

    /**
     * @var string
     */
    public $Address;

    /**
     * @inheritdoc
     */
    public function __construct(&$data, DataReconstructor $dataReconstructor, array $map)
    {
        $this->Start = new \DateTime(sprintf(
            '%d-%d-%d',
            $data['StartYear'],
            $data['StartMonth'],
            $data['StartDay']
        ));
        $this->End = new \DateTime(sprintf(
            '%d-%d-%d',
            $data['EndYear'],
            $data['EndMonth'],
            $data['EndDay']
        ));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Title;
    }
}
