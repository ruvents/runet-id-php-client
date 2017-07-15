<?php

namespace RunetId\ApiClient\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MockDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return true;
    }
}
