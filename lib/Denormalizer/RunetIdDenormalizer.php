<?php

namespace RunetId\ApiClient\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * @property DenormalizerInterface $serializer
 */
class RunetIdDenormalizer extends SerializerAwareNormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $object = new $class();

        if (!$object instanceof RunetIdDenormalizableInterface) {
            throw new \UnexpectedValueException(
                sprintf('"%s" must implement RunetIdDenormalizableInterface.', get_class($object))
            );
        }

        $object->runetIdDenormalize($this->serializer, $data, $format, $context);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $class, $format = null)
    {
        return class_exists($class)
            && is_subclass_of($class, 'RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface');
    }
}
