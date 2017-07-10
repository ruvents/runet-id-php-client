<?php

namespace RunetId\ApiClient\Model\Common;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class GeoPoint implements RunetIdDenormalizableInterface
{
    use ClassTrait;

    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    /**
     * @var float
     */
    protected $scale;

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * {@inheritdoc}
     */
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->latitude = (float)$data[0];
        $this->longitude = (float)$data[1];
        $this->scale = (float)$data[2];
    }
}
