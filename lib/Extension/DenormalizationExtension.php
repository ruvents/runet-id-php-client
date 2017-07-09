<?php

namespace RunetId\ApiClient\Extension;

use Psr\Http\Message\RequestInterface;
use RunetId\ApiClient\Denormalizer\ModelDenormalizer;
use Ruvents\AbstractApiClient\Extension\AbstractDenormalizationExtension;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class DenormalizationExtension extends AbstractDenormalizationExtension
{
    /**
     * @var string[]
     */
    private static $classes = [
        '/user/get' => 'RunetId\ApiClient\Model\User\UserInterface',
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct(DenormalizerInterface $denormalizer = null)
    {
        $denormalizer = $denormalizer ?: new Serializer([new ModelDenormalizer()]);
        parent::__construct($denormalizer);
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass(RequestInterface $request)
    {
        $path = $request->getUri()->getPath();

        return isset(self::$classes[$path]) ? self::$classes[$path] : null;
    }
}
