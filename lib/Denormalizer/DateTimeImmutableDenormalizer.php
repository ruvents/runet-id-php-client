<?php

namespace RunetId\ApiClient\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DateTimeImmutableDenormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new \DateTimeImmutable($data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $class, $format = null, array $context = [])
    {
        return 'DateTimeImmutable' === $class;
    }
}
