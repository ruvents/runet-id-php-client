<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Model\AbstractModel;

/**
 * @property string $Small
 * @property string $Medium
 * @property string $Large
 * @property string $Original
 */
class Photo extends AbstractModel
{
    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Original;
    }
}
