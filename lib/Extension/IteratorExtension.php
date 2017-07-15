<?php

namespace RunetId\ApiClient\Extension;

use Ruvents\AbstractApiClient\Event\Events;
use Ruvents\AbstractApiClient\Event\PreSendEvent;
use Ruvents\AbstractApiClient\Extension\ApiClientAwareInterface;
use Ruvents\AbstractApiClient\Extension\ApiClientAwareTrait;
use Ruvents\AbstractApiClient\Extension\ExtensionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IteratorExtension implements ExtensionInterface, ApiClientAwareInterface
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
     * {@inheritdoc}
     */
    public function configureContext(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'denormalizer' => null,
                'use_iterators' => true,
            ])
            ->setAllowedTypes('denormalizer', ['null', 'Symfony\Component\Serializer\Normalizer\DenormalizerInterface'])
            ->setAllowedTypes('use_iterators', 'bool');
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::PRE_SEND => 'createIterator',
        ];
    }

    public function createIterator(PreSendEvent $event)
    {
        $context = $event->getContext();

        if (!$context['use_iterators']) {
            return;
        }

        /** @var string $endpoint */
        $endpoint = $context['endpoint'];

        if (isset(self::$endpointIterators[$endpoint])) {
            $class = self::$endpointIterators[$endpoint];
            $iterator = new $class($this->apiClient, $context);
            $event->setData($iterator);
        }
    }
}
