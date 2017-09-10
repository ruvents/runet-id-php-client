<?php

namespace RunetId\ApiClient\Result\User;

use RunetId\ApiClient\Result\AbstractResult;

/**
 * @property string $Small
 * @property string $Medium
 * @property string $Large
 * @property string $Original
 */
class Photo extends AbstractResult
{
    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Original;
    }
}
