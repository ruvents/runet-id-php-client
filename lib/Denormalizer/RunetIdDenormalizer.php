<?php

namespace RunetId\ApiClient\Denormalizer;

use Ruvents\AbstractApiClient\Service\ServiceInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RunetIdDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    const OBJECT_TO_POPULATE = 'object_to_populate';

    /**
     * @var DenormalizerInterface
     */
    protected $denormalizer;

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $object = $this->instantiateObject($data, $class, $context);

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

    /**
     * @param mixed  $data
     * @param string $class
     * @param array  $context
     *
     * @return RunetIdDenormalizableInterface
     */
    protected function instantiateObject(
        /** @noinspection PhpUnusedParameterInspection */
        &$data,
        $class,
        array &$context = []
    ) {
        if (isset($context[self::OBJECT_TO_POPULATE])) {
            $object = $context[self::OBJECT_TO_POPULATE];
            unset($context[self::OBJECT_TO_POPULATE]);

            return $object;
        }

        return new $class();
    }
}
