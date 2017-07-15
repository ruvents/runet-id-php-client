<?php

namespace RunetId\ApiClient\Extension;

use RunetId\ApiClient\Denormalizer\RunetIdDenormalizer;
use Ruvents\AbstractApiClient\Event\Events;
use Ruvents\AbstractApiClient\Event\PostDecodeEvent;
use Ruvents\AbstractApiClient\Event\PreSendEvent;
use Ruvents\AbstractApiClient\Extension\ApiClientAwareInterface;
use Ruvents\AbstractApiClient\Extension\ApiClientAwareTrait;
use Ruvents\AbstractApiClient\Extension\ExtensionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Serializer;

class DenormalizationExtension implements ExtensionInterface, ApiClientAwareInterface
{
    use ApiClientAwareTrait;

    /**
     * @var string[]
     */
    private static $endpointIterators = [
        '/event/users' => 'RunetId\ApiClient\Iterator\UserIterator',
        '/user/search' => 'RunetId\ApiClient\Iterator\UserIterator',
    ];

    /**
     * @var string[]
     */
    private static $endpointModels = [
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
    protected $denormalizer;

    public function __construct(DenormalizerInterface $denormalizer = null)
    {
        $this->denormalizer = $denormalizer
            ?: new Serializer([
                new ArrayDenormalizer(),
                new RunetIdDenormalizer(),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureContext(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'denormalize' => true,
                'class' => null,
            ])
            ->setAllowedTypes('denormalize', 'bool')
            ->setAllowedTypes('class', ['null', 'string']);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::PRE_SEND => 'denormalizeToIterator',
            Events::POST_DECODE => 'denormalizeToModel',
        ];
    }

    public function denormalizeToIterator(PreSendEvent $event)
    {
        $context = $event->getContext();

        if (!$context['denormalize']) {
            return;
        }

        /** @var string $endpoint */
        $endpoint = $context['endpoint'];

        if (isset(self::$endpointIterators[$endpoint])) {
            $class = self::$endpointIterators[$endpoint];
            $iterator = new $class($this->apiClient, $this->denormalizer, $context);
            $event->setData($iterator);
        }
    }

    public function denormalizeToModel(PostDecodeEvent $event)
    {
        $context = $event->getContext();

        if (!$context['denormalize']) {
            return;
        }

        $data = $event->getData();

        if (is_array($data) && isset($data['Success']) && true === $data['Success']) {
            $event->setData(true);

            return;
        }

        /** @var string $endpoint */
        $endpoint = $context['endpoint'];
        $class = $context['class'];

        if (null === $class && isset(self::$endpointModels[$endpoint])) {
            $class = self::$endpointModels[$endpoint];
        }

        if (null !== $class && $this->denormalizer->supportsDenormalization($data, $class)) {
            $event->setData($this->denormalizer->denormalize($data, $class, null, [
                'api_client' => $this->apiClient,
            ]));
        }
    }
}
