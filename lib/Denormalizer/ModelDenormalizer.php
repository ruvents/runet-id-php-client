<?php

namespace RunetId\ApiClient\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * @property DenormalizerInterface $serializer
 */
class ModelDenormalizer extends SerializerAwareNormalizer implements DenormalizerInterface
{
    /**
     * @var string[]
     */
    private static $models = [
        'RunetId\ApiClient\Model\Company\Company' => true,
        'RunetId\ApiClient\Model\Event\Role' => true,
        'RunetId\ApiClient\Model\User\Photo' => true,
        'RunetId\ApiClient\Model\User\User' => true,
        'RunetId\ApiClient\Model\User\Work' => true,
    ];

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $object = new $class();

        if (!$object instanceof RunetIdDenormalizableInterface) {
            throw new \UnexpectedValueException('Class defined in ModelDenormalizer must implement RunetIdDenormalizableInterface by design.');
        }

        $object->runetIdDenormalize($this->serializer, $data, $format, $context);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $class, $format = null)
    {
        return isset(self::$models[$class]);
    }
}
