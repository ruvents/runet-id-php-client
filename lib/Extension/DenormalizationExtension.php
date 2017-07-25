<?php

namespace RunetId\ApiClient\Extension;

use RunetId\ApiClient\Denormalizer\RunetIdDenormalizer;
use Ruvents\AbstractApiClient\Event\Events;
use Ruvents\AbstractApiClient\Event\PostDecodeEvent;
use Ruvents\AbstractApiClient\Extension\ExtensionInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class DenormalizationExtension implements ExtensionInterface
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
    public function configureContext(OptionsResolver $resolver)
    {
        /** @noinspection PhpUnusedParameterInspection */
        $resolver
            ->setDefaults([
                'class' => function (Options $context) {
                    return $this->getEndpointClass($context['endpoint']);
                },
                'denormalize' => true,
                'denormalizer' => function (Options $context) {
                    return new Serializer([
                        new ArrayDenormalizer(),
                        new RunetIdDenormalizer(),
                    ]);
                },
            ])
            ->setAllowedTypes('class', ['null', 'string'])
            ->setAllowedTypes('denormalize', 'bool')
            ->setAllowedTypes('denormalizer', 'Symfony\Component\Serializer\Normalizer\DenormalizerInterface');
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::POST_DECODE => 'denormalize',
        ];
    }

    public function denormalize(PostDecodeEvent $event)
    {
        $context = $event->getContext();

        if (false === $context['denormalize']) {
            return;
        }

        $data = $event->getData();

        if (is_array($data) && isset($data['Success']) && true === $data['Success']) {
            $event->setData(true);

            return;
        }

        /**
         * @var string                $class
         * @var DenormalizerInterface $denormalizer
         */
        $class = $context['class'];
        $denormalizer = $context['denormalizer'];

        if (null !== $class && $denormalizer->supportsDenormalization($data, $class)) {
            $event->setData($denormalizer->denormalize($data, $class));
        }
    }

    /**
     * @param string $endpoint
     *
     * @return null|string
     */
    protected function getEndpointClass($endpoint)
    {
        return isset(self::$endpointClasses[$endpoint]) ? self::$endpointClasses[$endpoint] : null;
    }
}
