<?php

namespace RunetId\ApiClient\Model\Common;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Model\ModelInterface;

class Address implements ModelInterface
{
    use ClassTrait;

    /**
     * @var null|string
     */
    protected $country;

    /**
     * @var null|string
     */
    protected $region;

    /**
     * @var null|string
     */
    protected $city;

    /**
     * @var null|string
     */
    protected $postCode;

    /**
     * @var null|string
     */
    protected $street;

    /**
     * @var null|string
     */
    protected $house;

    /**
     * @var null|string
     */
    protected $building;

    /**
     * @var null|string
     */
    protected $wing;

    /**
     * @var null|string
     */
    protected $apartment;

    /**
     * @var null|string
     */
    protected $place;

    /**
     * @return null|string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return null|string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @return null|string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return null|string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @return null|string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return null|string
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * @return null|string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @return null|string
     */
    public function getWing()
    {
        return $this->wing;
    }

    /**
     * @return null|string
     */
    public function getApartment()
    {
        return $this->apartment;
    }

    /**
     * @return null|string
     */
    public function getPlace()
    {
        return $this->place;
    }
}
