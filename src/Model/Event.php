<?php

namespace RunetId\ApiClient\Model;

/**
 * Event
 */
class Event
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
     * @var string
     */
    public $StartYear;

    /**
     * @var string
     */
    public $StartMonth;

    /**
     * @var string
     */
    public $StartDay;

    /**
     * @var string
     */
    public $EndYear;

    /**
     * @var string
     */
    public $EndMonth;

    /**
     * @var string
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
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Title;
    }
}
