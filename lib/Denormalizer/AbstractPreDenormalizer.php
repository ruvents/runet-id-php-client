<?php

namespace RunetId\ApiClient\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractPreDenormalizer implements DenormalizerInterface
{
    const PREFIX = '(array)';
    const PREFIX_LENGTH = 7;

    /**
     * @var array
     */
    private $maps;

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
        $class = $this->extractClass($type);

        if (!isset($this->maps[$class])) {
            $this->maps[$class] = $this->getMap($class);
        }

        $data = [];

        foreach ($this->maps[$class] as $key => $config) {
            if (is_callable($config)) {
                $exists = true;
                $value = $config($raw, $exists, $context);

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

        return $this->supportsClass($this->extractClass($type));
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    abstract protected function supportsClass($class);

    /**
     * @param string $class
     *
     * @return array
     */
    abstract protected function getMap($class);

    /**
     * @param string $type
     *
     * @return null|string
     */
    private function extractClass($type)
    {
        return substr($type, self::PREFIX_LENGTH) ?: null;
    }
}
