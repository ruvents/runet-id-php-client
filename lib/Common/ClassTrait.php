<?php

namespace RunetId\ApiClient\Common;

trait ClassTrait
{
    /**
     * @return string
     */
    final public static function className()
    {
        return get_called_class();
    }
}
