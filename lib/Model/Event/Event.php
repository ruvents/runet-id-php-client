<?php

namespace RunetId\ApiClient\Model\Event;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\PreDenormalizableInterface;
use RunetId\ApiClient\Model\Common\GeoPoint;
use RunetId\ApiClient\Model\ModelInterface;

class Event implements ModelInterface, EventIdInterface, PreDenormalizableInterface
{
    use ClassTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $alias;

    /**
     * @var null|string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $info;

    /**
     * @var null|string
     */
    protected $fullInfo;

    /**
     * @var null|string
     */
    protected $place;

    /**
     * @var null|string
     */
    protected $url;

    /**
     * @var null|string
     */
    protected $registrationUrl;

    /**
     * @var null|string
     */
    protected $programUrl;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $start;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $end;

    /**
     * @var null|GeoPoint
     */
    protected $geoPoint;

    /**
     * @var null|string
     */
    protected $address;

    /**
     * @var null|array
     */
    protected $statistics;

    public function __toString()
    {
        return (string)$this->title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @return null|string
     */
    public function getFullInfo()
    {
        return $this->fullInfo;
    }

    /**
     * @return null|string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return null|string
     */
    public function getRegistrationUrl()
    {
        return $this->registrationUrl;
    }

    /**
     * @return null|string
     */
    public function getProgramUrl()
    {
        return $this->programUrl;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return null|GeoPoint
     */
    public function getGeoPoint()
    {
        return $this->geoPoint;
    }

    /**
     * @return null|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return null|array
     */
    public function getStatistics()
    {
        return $this->statistics;
    }

    /**
     * {@inheritdoc}
     */
    public static function getRunetIdPreDenormalizationMap()
    {
        return [
            'id' => 'EventId',
            'alias' => 'IdName',
            'title' => 'Title',
            'info' => 'Info',
            'fullInfo' => 'FullInfo',
            'place' => 'Place',
            'url' => 'Url',
            'registrationUrl' => 'UrlRegistration',
            'programUrl' => 'UrlProgram',
            'address' => 'Address',
            'geoPoint' => function (array $raw, &$exists) {
                if ($exists = isset($raw['GeoPoint'])) {
                    return '' !== ($raw['GeoPoint'][0]) && '' !== ($raw['GeoPoint'][1]) && '' !== ($raw['GeoPoint'][2])
                        ? $raw['GeoPoint']
                        : null;
                }

                return null;
            },
            'start' => function (array $raw, &$exists) {
                if ($exists = isset($raw['StartYear']) && isset($raw['StartMonth']) && isset($raw['StartDay'])) {
                    return $raw['StartYear'].'-'.$raw['StartMonth'].'-'.$raw['StartDay'];
                }

                return null;
            },
            'end' => function (array $raw, &$exists) {
                if ($exists = isset($raw['EndYear']) && isset($raw['EndMonth']) && isset($raw['EndDay'])) {
                    return $raw['EndYear'].'-'.$raw['EndMonth'].'-'.$raw['EndDay'];
                }

                return null;
            },
        ];
    }
}
