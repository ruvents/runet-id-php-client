<?php

namespace RunetId\ApiClient\Denormalizer;

use RunetId\ApiClient\PropertyInfo\ModelTypeExtractor;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ModelDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    const DEFAULT_VALUE = 'default_value';
    const OBJECT_TO_POPULATE = AbstractNormalizer::OBJECT_TO_POPULATE;
    const PARENT_OBJECT = 'parent_object';

    /**
     * @var SerializerInterface|DenormalizerInterface
     */
    protected $serializer;

    /**
     * @var PropertyTypeExtractorInterface
     */
    private $extractor;

    /**
     * {@inheritdoc}
     */
    public function __construct(PropertyTypeExtractorInterface $extractor = null)
    {
        $this->extractor = $extractor ?: new ModelTypeExtractor();
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        /** @var array $data */
        $data = $this->serializer->denormalize((array)$data, AbstractPreDenormalizer::getType($class), $format, $context);
        $this->preDenormalize($data, $class, $format, $context);

        $object = $this->instantiateObject($data, $class, $format, $context);

        $getter = \Closure::bind(function ($property) {
            return $this->$property;
        }, $object, $object);

        $setter = \Closure::bind(function ($property, $value) {
            return $this->$property = $value;
        }, $object, $object);

        foreach ($data as $property => $propertyData) {
            $defaultValue = $getter($property);
            $value = $this->validateAndDenormalizeProperty($object, $property, $propertyData, $defaultValue, $format, $context);
            $setter($property, $value);
        }

        $this->postDenormalize($object, $format, $context);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = [])
    {
        return is_subclass_of($type, 'RunetId\ApiClient\Model\ModelInterface')
            && $this->serializer->supportsDenormalization($data, AbstractPreDenormalizer::getType($type), $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        if (!$serializer instanceof DenormalizerInterface) {
            throw new Exception\InvalidArgumentException('Expected a serializer that also implements DenormalizerInterface.');
        }

        $this->serializer = $serializer;
    }

    /**
     * @param array       $data
     * @param string      $class
     * @param null|string $format
     * @param array       $context
     */
    protected function preDenormalize(array &$data, $class, $format = null, array &$context)
    {
    }

    /**
     * @param mixed       $data
     * @param string      $class
     * @param null|string $format
     * @param array       $context
     *
     * @return object
     */
    protected function instantiateObject(array &$data, $class, $format = null, array &$context)
    {
        if (isset($context[self::OBJECT_TO_POPULATE]) && $context[self::OBJECT_TO_POPULATE] instanceof $class) {
            $object = $context[self::OBJECT_TO_POPULATE];
            unset($context[self::OBJECT_TO_POPULATE]);

            return $object;
        }

        if (isset($context[self::DEFAULT_VALUE]) && $context[self::DEFAULT_VALUE] instanceof $class) {
            return $context[self::DEFAULT_VALUE];
        }

        return new $class();
    }

    /**
     * Validates the property value and denormalizes it.
     *
     * @see \Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer::validateAndDenormalize()
     *
     * @param object      $object
     * @param string      $property
     * @param mixed       $data
     * @param mixed       $defaultValue
     * @param null|string $format
     * @param array       $context
     *
     * @return mixed
     *
     * @throws Exception\UnexpectedValueException
     * @throws Exception\LogicException
     */
    protected function validateAndDenormalizeProperty($object, $property, $data, $defaultValue, $format = null, array $context = [])
    {
        if (null === $types = $this->extractor->getTypes(get_class($object), $property)) {
            return $data;
        }

        $expectedTypes = [];

        foreach ($types as $type) {
            // empty strings fix
            if (is_string($data)) {
                $data = trim($data);

                if ('' === $data) {
                    $data = null;
                }
            }

            if (null === $data && $type->isNullable()) {
                return $data;
            }

            if ($type->isCollection() && null !== ($collectionValueType = $type->getCollectionValueType()) && Type::BUILTIN_TYPE_OBJECT === $collectionValueType->getBuiltinType()) {
                $builtinType = Type::BUILTIN_TYPE_OBJECT;
                $class = $collectionValueType->getClassName().'[]';

                if (null !== $collectionKeyType = $type->getCollectionKeyType()) {
                    $context['key_type'] = $collectionKeyType;
                }
            } else {
                $builtinType = $type->getBuiltinType();
                $class = $type->getClassName();
            }

            $expectedTypes[Type::BUILTIN_TYPE_OBJECT === $builtinType && $class ? $class : $builtinType] = true;

            if (Type::BUILTIN_TYPE_OBJECT === $builtinType) {
                $childContext = $this->createChildContext($object, $property, $data, $defaultValue, $format, $context);

                /** @noinspection PhpMethodParametersCountMismatchInspection */
                if ($this->serializer->supportsDenormalization($data, $class, $format, $childContext)) {
                    return $this->serializer->denormalize($data, $class, $format, $childContext);
                }

                continue;
            }

            // json float fix
            if (Type::BUILTIN_TYPE_FLOAT === $builtinType && is_int($data) && false !== strpos($format, JsonEncoder::FORMAT)) {
                return (float)$data;
            }

            if (call_user_func('is_'.$builtinType, $data)) {
                return $data;
            }
        }

        throw new Exception\UnexpectedValueException(sprintf('The type of the "%s" property for class "%s" must be one of "%s" ("%s" given).', $property, get_class($object), implode('", "', array_keys($expectedTypes)), gettype($data)));
    }

    /**
     * @param object      $object
     * @param string      $property
     * @param mixed       $data
     * @param mixed       $defaultValue
     * @param null|string $format
     * @param array       $context
     *
     * @return array
     */
    protected function createChildContext($object, $property, $data, $defaultValue, $format = null, array $context = [])
    {
        return array_replace($context, [
            self::DEFAULT_VALUE => $defaultValue,
            self::PARENT_OBJECT => $object,
        ]);
    }

    /**
     * @param object      $object
     * @param null|string $format
     * @param array       $context
     */
    protected function postDenormalize($object, $format = null, array &$context)
    {
    }
}
