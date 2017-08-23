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
    private static $iteratorClasses = [
        '/event/search' => 'RunetId\ApiClient\Iterator\PageTokenIterator',
        '/event/users' => 'RunetId\ApiClient\Iterator\PageTokenIterator',
    ];

    /**
     * {@inheritdoc}
     */
    public function configureDefaultContext(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'iterator' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureRequestContext(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'iterator_class' => function (Options $context, $default) {
                    $endpoint = $context['endpoint'];

                    return isset(self::$iteratorClasses[$endpoint]) ? self::$iteratorClasses[$endpoint] : $default;
                },
            ])
            ->setAllowedValues('iterator_class', function ($class) {
                if (null === $class || is_subclass_of($class, 'RunetId\ApiClient\Iterator\IteratorInterface')) {
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

        if (!$context['iterator'] || null === $context['iterator_class']) {
            return;
        }

        $class = $context['iterator_class'];

        /** @var IteratorInterface $iterator */
        $iterator = new $class();
        $iterator->setContext($context);

        $event->setData($iterator);
    }
}
