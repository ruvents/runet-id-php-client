<?php

namespace RunetId\ApiClient\Denormalizer;

interface PreDenormalizableInterface
{
    /**
     * @return array
     */
    public static function getRunetIdPreDenormalizationMap();
}
