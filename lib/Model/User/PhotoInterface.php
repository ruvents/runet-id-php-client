<?php

namespace RunetId\ApiClient\Model\User;

interface PhotoInterface
{
    const SMALL = 'small';
    const MEDIUM = 'medium';
    const LARGE = 'large';

    /**
     * @param string $type
     *
     * @return string|null
     */
    public function getUrl($type = self::LARGE);
}
