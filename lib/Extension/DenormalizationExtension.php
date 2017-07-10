<?php

namespace RunetId\ApiClient\Extension;

use Psr\Http\Message\RequestInterface;
use RunetId\ApiClient\Denormalizer\RunetIdDenormalizer;
use Ruvents\AbstractApiClient\Extension\AbstractDenormalizationExtension;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class DenormalizationExtension extends AbstractDenormalizationExtension
{
    /**
     * @var string[]
     */
    private static $endpointClasses = [
        '/event/info' => 'RunetId\ApiClient\Model\Event\Event',
        '/event/roles' => 'RunetId\ApiClient\Model\Event\Role[]',
        '/user/address' => 'RunetId\ApiClient\Model\Common\Address',
        '/user/auth' => 'RunetId\ApiClient\Model\User\User',
        '/user/create' => 'RunetId\ApiClient\Model\User\User',
        '/user/edit' => 'RunetId\ApiClient\Model\User\User',
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
                new RunetIdDenormalizer(),
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

        return isset(self::$endpointClasses[$endpoint]) ? self::$endpointClasses[$endpoint] : null;
    }
}
