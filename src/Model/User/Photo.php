<?php

namespace RunetId\ApiClient\Model\User;

/**
 * User photo
 */
class Photo
{
    /**
     * @var string
     */
    public $Small;

    /**
     * @var string
     */
    public $Medium;

    /**
     * @var string
     */
    public $Large;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->Large;
    }

    /**
     * @return bool
     */
    public function hasPhoto()
    {
        return '/files/photo/nophoto_50.png' !== parse_url($this->Small, PHP_URL_PATH);
    }
}
