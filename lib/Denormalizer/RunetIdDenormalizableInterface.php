<?php

namespace RunetId\ApiClient\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

interface RunetIdDenormalizableInterface
{
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = []);
}
