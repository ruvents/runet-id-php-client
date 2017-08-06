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
    private $iteratorClasses = [
        '/event/search' => 'RunetId\ApiClient\Iterator\PageTokenIterator',
        '/event/users' => 'RunetId\ApiClient\Iterator\PageTokenIterator',
    ];

    /**
     * @var string[]
     */
    private $dataPaths = [
        '/event/search' => 'Users',
        '/event/users' => 'Users',
    ];

    /**
     * @param string[] $iteratorClasses
     */
    public function __construct($iteratorClasses = [])
    {
        $this->iteratorClasses = array_merge($this->iteratorClasses, $iteratorClasses);
    }

    /**
     * {@inheritdoc}
     */
    public function configureContext(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_path' => function (Options $context) {
                    $endpoint = $context['endpoint'];

                    return isset($this->dataPaths[$endpoint]) ? $this->dataPaths[$endpoint] : null;
                },
                'iterator' => true,
                'iterator_class' => function (Options $context) {
                    $endpoint = $context['endpoint'];

                    return isset($this->iteratorClasses[$endpoint]) ? $this->iteratorClasses[$endpoint] : null;
                },
            ])
            ->setAllowedTypes('data_path', ['null', 'string'])
            ->setAllowedTypes('iterator', 'bool')
            ->setAllowedValues('iterator_class', function ($class) {
                if (null === $class) {
                    return true;
                }

                if (is_string($class) && class_exists($class)
                    && isset(class_implements($class)['RunetId\ApiClient\Iterator\IteratorInterface'])
                ) {
                    return true;
                }

                throw new InvalidOptionsException('The option "iterator_class" must be null or a name of the class, implementing "RunetId\ApiClient\Iterator\IteratorInterface".');
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
}
