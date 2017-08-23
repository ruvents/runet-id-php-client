<?php

namespace RunetId\ApiClient\Denormalizer;

class PreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function supportsClass($class)
    {
        return is_subclass_of($class, 'RunetId\ApiClient\Denormalizer\PreDenormalizableInterface');
    }

    /**
     * {@inheritdoc}
     */
    protected function getMap($class)
    {
        return call_user_func([$class, 'getRunetIdPreDenormalizationMap']);
    }
}
