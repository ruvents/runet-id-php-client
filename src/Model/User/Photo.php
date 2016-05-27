<?php

namespace RunetId\ApiClient\Model\User;

/**
 * User photo
 */
class Photo
{
    const NOPHOTO_SMALL_PATH = '/files/photo/nophoto_50.png';

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
    public function isEmpty()
    {
        return self::NOPHOTO_SMALL_PATH === parse_url($this->Small, PHP_URL_PATH);
    }
}
