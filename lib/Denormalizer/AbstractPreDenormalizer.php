<?php

namespace RunetId\ApiClient\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractPreDenormalizer implements DenormalizerInterface
{
    const PREFIX = '(array)';
    const PREFIX_LENGTH = 7;

    /**
     * @var null|array
     */
    protected $map;

    /**
     * @param string $class
     *
     * @return string
     */
    final public static function getType($class)
    {
        return self::PREFIX.$class;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($raw, $type, $format = null, array $context = [])
    {
        if (null === $this->map) {
            $this->map = $this->getMap();
        }

        $data = [];

        foreach ($this->map as $key => $config) {
            if (is_callable($config)) {
                $exists = true;
                $value = $config($raw, $exists);

                if (!$exists) {
                    continue;
                }
            } else {
                if (!array_key_exists($config, $raw)) {
                    continue;
                }

                $value = $raw[$config];
            }

            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null, array $context = [])
    {
        if (0 !== strpos($type, self::PREFIX)) {
            return false;
        }

        $class = substr($type, self::PREFIX_LENGTH);
        $supportedClass = $this->getSupportedClass();

        return $class === $supportedClass || is_subclass_of($class, $supportedClass);
    }

    /**
     * @return array
     */
    abstract protected function getMap();

    /**
     * @return string
     */
    abstract protected function getSupportedClass();
}
