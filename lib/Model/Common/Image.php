<?php

namespace RunetId\ApiClient\Model\Common;

use RunetId\ApiClient\Common\ClassTrait;

class Image
{
    use ClassTrait;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var null|int
     */
    protected $width;

    /**
     * @var null|int
     */
    protected $height;

    public function __construct($url, $width = null, $height = null)
    {
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
    }

    public function __toString()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return null|int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return null|int
     */
    public function getHeight()
    {
        return $this->height;
    }
}
