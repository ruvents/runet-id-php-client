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
    private static $implementations = [
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
        $class = self::$implementations[$interface];
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
    public function supportsDenormalization($data, $interface, $format = null)
    {
        return isset(self::$implementations[$interface]);
    }
}
