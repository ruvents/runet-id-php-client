<?php

namespace RunetId\ApiClient\Model\Common;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Model\ModelInterface;

class GeoPoint implements ModelInterface
{
    use ClassTrait;

    /**
     * @var null|float
     */
    protected $latitude;

    /**
     * @var null|float
     */
    protected $longitude;

    /**
     * @var null|float
     */
    protected $scale;

    /**
     * @return null|float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return null|float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return null|float
     */
    public function getScale()
    {
        return $this->scale;
    }
}
