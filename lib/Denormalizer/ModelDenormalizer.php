<?php

namespace RunetId\ApiClient\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * @property DenormalizerInterface $serializer
 */
class ModelDenormalizer extends SerializerAwareNormalizer implements DenormalizerInterface
{
    private static $classes = [
        'RunetId\ApiClient\Model\Company\CompanyInterface' => 'RunetId\ApiClient\Model\Company\Company',
        'RunetId\ApiClient\Model\Event\RoleInterface' => 'RunetId\ApiClient\Model\Event\Role',
        'RunetId\ApiClient\Model\User\PhotoInterface' => 'RunetId\ApiClient\Model\User\Photo',
        'RunetId\ApiClient\Model\User\UserInterface' => 'RunetId\ApiClient\Model\User\User',
        'RunetId\ApiClient\Model\User\WorkInterface' => 'RunetId\ApiClient\Model\User\Work',
    ];

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $interface, $format = null, array $context = [])
    {
        $class = self::$classes[$interface];
        $interfaces = class_implements($class);

        if (isset($interfaces['Symfony\Component\Serializer\Normalizer\DenormalizableInterface'])) {
            /** @var DenormalizableInterface $object */
            $object = new $class();
            $object->denormalize($this->serializer, $data, $format, $context);
        } else {
            $object = new $class($data);
        }

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $interface, $format = null)
    {
        return isset(self::$classes[$interface]);
    }
}
