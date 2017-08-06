<?php

namespace RunetId\ApiClient\Extension;

use RunetId\ApiClient\Iterator\IteratorInterface;
use Ruvents\AbstractApiClient\Event\Events;
use Ruvents\AbstractApiClient\Event\PreSendEvent;
use Ruvents\AbstractApiClient\Extension\ExtensionInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IteratorExtension implements ExtensionInterface
{
    /**
     * @var string[]
     */
    private $endpointConfigs = [
        '/event/users' => [
            'iterator_class' => 'RunetId\ApiClient\Iterator\PageTokenIterator',
            'iterator_data_extractor' => 'Users',
            'iterator_data_class' => 'RunetId\ApiClient\Model\User\User[]',
        ],
        '/event/search' => [
            'iterator_class' => 'RunetId\ApiClient\Iterator\PageTokenIterator',
            'iterator_data_extractor' => 'Users',
            'iterator_data_class' => 'RunetId\ApiClient\Model\User\User[]',
        ],
    ];

    /**
     * @param array $endpointConfigs
     */
    public function __construct($endpointConfigs = [])
    {
        $this->endpointConfigs = array_merge($this->endpointConfigs, $endpointConfigs);
    }

    /**
     * {@inheritdoc}
     */
    public function configureContext(OptionsResolver $resolver)
    {
        /** @noinspection PhpUnusedParameterInspection */
        $resolver
            ->setDefaults([
                'iterator' => true,
                'iterator_class' => function (Options $context) {
                    return $this->getEndpointConfig($context['endpoint'])['iterator_class'];
                },
                'iterator_data_extractor' => function (Options $context) {
                    return $this->getEndpointConfig($context['endpoint'])['iterator_data_extractor'];
                },
                'iterator_data_class' => function (Options $context) {
                    return $this->getEndpointConfig($context['endpoint'])['iterator_data_class'];
                },
            ])
            ->setAllowedTypes('iterator', 'bool')
            ->setAllowedTypes('iterator_class', ['null', 'string'])
            ->setAllowedTypes('iterator_data_extractor', ['null', 'string', 'callable'])
            ->setAllowedTypes('iterator_data_class', ['null', 'string'])
            ->setNormalizer('iterator_class', function (Options $options, $class) {
                if (null === $class) {
                    return null;
                }

                if (!isset(class_implements($class)['RunetId\ApiClient\Iterator\IteratorInterface'])) {
                    throw new InvalidOptionsException('The option "iterator_class" must be null or an a FQCN, implementing "RunetId\ApiClient\Iterator\IteratorInterface"');
                }

                return $class;
            });
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::PRE_SEND => 'preSend',
        ];
    }

    public function preSend(PreSendEvent $event)
    {
        $context = $event->getContext();

        if (false === $context['iterator'] || null === $context['iterator_class']) {
            return;
        }

        $class = $context['iterator_class'];

        /** @var IteratorInterface $iterator */
        $iterator = new $class();
        $iterator->setContext($context);

        $event->setData($iterator);
    }

    /**
     * @param string $endpoint
     *
     * @return null|array
     */
    protected function getEndpointConfig($endpoint)
    {
        return isset($this->endpointConfigs[$endpoint]) ? $this->endpointConfigs[$endpoint] : null;
    }
}
