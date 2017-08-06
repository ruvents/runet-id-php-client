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
    private $endpointClasses = [
        '/event/info' => 'RunetId\ApiClient\Model\Event\Event',
        '/event/roles' => 'RunetId\ApiClient\Model\Event\Role[]',
        '/user/address' => 'RunetId\ApiClient\Model\Common\Address',
        '/user/auth' => 'RunetId\ApiClient\Model\User\User',
        '/user/create' => 'RunetId\ApiClient\Model\User\User',
        '/user/edit' => 'RunetId\ApiClient\Model\User\User',
        '/user/get' => 'RunetId\ApiClient\Model\User\User',
    ];

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * @param string[]                   $endpointClasses
     * @param null|DenormalizerInterface $denormalizer
     */
    public function __construct($endpointClasses = [], DenormalizerInterface $denormalizer = null)
    {
        $this->endpointClasses = array_merge($this->endpointClasses, $endpointClasses);
        $this->denormalizer = $denormalizer ?: new Serializer([new ArrayDenormalizer(), new RunetIdDenormalizer()]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureContext(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'class' => function (Options $context) {
                    return $this->getEndpointClass($context['endpoint']);
                },
                'denormalize' => true,
            ])
            ->setAllowedTypes('class', ['null', 'string'])
            ->setAllowedTypes('denormalize', 'bool');
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

        /** @var null|string $class */
        $class = $context['class'];

        if (null !== $class && $this->denormalizer->supportsDenormalization($data, $class)) {
            $event->setData($this->denormalizer->denormalize($data, $class));
        }
    }

    /**
     * @param string $endpoint
     *
     * @return null|string
     */
    protected function getEndpointClass($endpoint)
    {
        return isset($this->endpointClasses[$endpoint]) ? $this->endpointClasses[$endpoint] : null;
    }
}
