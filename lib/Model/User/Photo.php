<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Photo implements RunetIdDenormalizableInterface
{
    const SMALL = 'sm';
    const MEDIUM = 'md';
    const LARGE = 'lg';

    /**
     * @var string[]
     */
    protected $urls = [];

    /**
     * @return string
     */
    public function getUrl($type = self::LARGE)
    {
        return isset($this->urls[$type]) ? $this->urls[$type] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->urls = array_filter([
            self::SMALL => isset($data['Small']) ? $data['Small'] : null,
            self::MEDIUM => isset($data['Medium']) ? $data['Medium'] : null,
            self::LARGE => isset($data['Large']) ? $data['Large'] : null,
        ]);
    }
}
