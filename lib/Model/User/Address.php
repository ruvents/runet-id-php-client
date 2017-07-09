<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Address implements RunetIdDenormalizableInterface
{
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

    /**
     * {@inheritdoc}
     */
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->country = $data['Country'] ?: null;
        $this->region = $data['Region'] ?: null;
        $this->city = $data['City'] ?: null;
        $this->postCode = $data['PostCode'] ?: null;
        $this->street = $data['Street'] ?: null;
        $this->house = $data['House'] ?: null;
        $this->building = $data['Building'] ?: null;
        $this->wing = $data['Wing'] ?: null;
        $this->apartment = $data['Apartment'] ?: null;
        $this->place = $data['Place'] ?: null;
    }
}
