<?php

namespace RunetId\ApiClient\Model\Event;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use RunetId\ApiClient\Model\Common\GeoPoint;
use RunetId\ApiClient\Model\Common\Image;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Event implements EventIdInterface, RunetIdDenormalizableInterface
{
    const IMAGE_SMALL = 'Mini';
    const IMAGE_MEDIUM = 'Normal';

    use ClassTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var string
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
     * @var string
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
     * @var \DateTimeImmutable
     */
    protected $start;

    /**
     * @var \DateTimeImmutable
     */
    protected $end;

    /**
     * @var Image[]
     */
    protected $images = [];

    /**
     * @var null|GeoPoint
     */
    protected $geoPoint;

    /**
     * @var null|string
     */
    protected $address;

    /**
     * @var array
     */
    protected $statistics;

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
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
     * @return string
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
     * @return \DateTimeInterface
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param string $size
     *
     * @return null|Image
     */
    public function getImage($size = self::IMAGE_MEDIUM)
    {
        return isset($this->images[$size]) ? $this->images[$size] : null;
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        return $this->images;
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
     * @return array
     */
    public function getStatistics()
    {
        return $this->statistics;
    }

    /**
     * {@inheritdoc}
     */
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->id = (int)$data['EventId'];
        $this->alias = $data['IdName'];
        $this->title = $data['Title'];
        $this->info = $data['Info'] ?: null;
        $this->fullInfo = $data['FullInfo'] ?: null;
        $this->place = $data['Place'] ?: null;
        $this->url = $data['Url'];
        $this->registrationUrl = $data['UrlRegistration'] ?: null;
        $this->programUrl = $data['UrlProgram'] ?: null;
        $this->start = new \DateTimeImmutable($data['StartYear'].'-'.$data['StartMonth'].'-'.$data['StartDay']);
        $this->end = new \DateTimeImmutable($data['EndYear'].'-'.$data['EndMonth'].'-'.$data['EndDay']);
        $this->address = $data['Address'] ?: null;

        // todo
        $this->statistics = (array)$data['Statistics'];

        foreach ($data['Image'] as $key => $value) {
            if (is_string($value)) {
                $this->images[$key] = new Image($value,
                    (int)$data['Image'][$key.'Size']['Width'],
                    (int)$data['Image'][$key.'Size']['Height']
                );
            }
        }

        if (!empty($data['GeoPoint'][0]) && !empty($data['GeoPoint'][1]) && !empty($data['GeoPoint'][2])) {
            $this->geoPoint = $denormalizer
                ->denormalize($data['GeoPoint'], GeoPoint::className(), $format, array_merge($context, [
                    'parent' => $this,
                ]));
        }
    }
}
