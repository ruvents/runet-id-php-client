<?php

namespace RunetId\ApiClient\Denormalizer;

use Ruvents\AbstractApiClient\Service\ServiceInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RunetIdDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    /**
     * @var DenormalizerInterface
     */
    protected $denormalizer;

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

        $object->runetIdDenormalize($this->denormalizer, $data, $format, $context);

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

    /**
     * {@inheritdoc}
     *
     * @param ServiceInterface|DenormalizerInterface $denormalizer
     *
     * @throws \InvalidArgumentException
     */
    public function setSerializer(SerializerInterface $denormalizer)
    {
        if (!$denormalizer instanceof DenormalizerInterface) {
            throw new \InvalidArgumentException(sprintf('Serializer must implement "Symfony\Component\Serializer\Normalizer\DenormalizerInterface".'));
        }

        $this->denormalizer = $denormalizer;
    }
}
