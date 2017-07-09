<?php

namespace RunetId\ApiClient\Model\User;

interface PhotoInterface
{
    const SMALL = 1;
    const MEDIUM = 2;
    const LARGE = 3;

    /**
     * @param int $type
     *
     * @return string|null
     */
    public function getUrl($type = self::LARGE);
}
