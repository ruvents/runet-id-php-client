<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Photo implements PhotoInterface, RunetIdDenormalizableInterface
{
    /**
     * @var string[]
     */
    protected $urls = [];

    /**
     * {@inheritdoc}
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
            PhotoInterface::SMALL => isset($data['Small']) ? $data['Small'] : null,
            PhotoInterface::MEDIUM => isset($data['Medium']) ? $data['Medium'] : null,
            PhotoInterface::LARGE => isset($data['Large']) ? $data['Large'] : null,
        ]);
    }
}
