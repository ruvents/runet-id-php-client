<?php

namespace RunetId\ApiClient\Extension;

use Psr\Http\Message\RequestInterface;
use RunetId\ApiClient\Denormalizer\ModelDenormalizer;
use Ruvents\AbstractApiClient\Extension\AbstractDenormalizationExtension;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class DenormalizationExtension extends AbstractDenormalizationExtension
{
    /**
     * @var string[]
     */
    private static $endpointModels = [
        '/user/get' => 'RunetId\ApiClient\Model\User\User',
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct(DenormalizerInterface $denormalizer = null)
    {
        if (null === $denormalizer) {
            $denormalizer = new Serializer([
                new ArrayDenormalizer(),
                new ModelDenormalizer(),
            ]);
        }

        parent::__construct($denormalizer);
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass(RequestInterface $request, array $context)
    {
        $endpoint = $context['endpoint'];

        return isset(self::$endpointModels[$endpoint]) ? self::$endpointModels[$endpoint] : null;
    }
}
