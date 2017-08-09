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
    private static $classes = [
        '/event/info' => 'RunetId\ApiClient\Model\Event\Event',
        '/event/roles' => 'RunetId\ApiClient\Model\Event\Role[]',
        '/event/search' => 'RunetId\ApiClient\Model\User\User[]',
        '/event/users' => 'RunetId\ApiClient\Model\User\User[]',
        '/user/address' => 'RunetId\ApiClient\Model\Common\Address',
        '/user/auth' => 'RunetId\ApiClient\Model\User\User',
        '/user/create' => 'RunetId\ApiClient\Model\User\User',
        '/user/edit' => 'RunetId\ApiClient\Model\User\User',
        '/user/get' => 'RunetId\ApiClient\Model\User\User',
    ];

    /**
     * @var string[]
     */
    private static $dataPaths = [
        '/event/search' => 'Users',
        '/event/users' => 'Users',
    ];

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    public function __construct(DenormalizerInterface $denormalizer = null)
    {
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
                    $endpoint = $context['endpoint'];

                    return isset(self::$classes[$endpoint]) ? self::$classes[$endpoint] : null;
                },
                'data_path' => function (Options $context) {
                    $endpoint = $context['endpoint'];

                    return isset(self::$dataPaths[$endpoint]) ? self::$dataPaths[$endpoint] : null;
                },
                'denormalize' => true,
                'denormalization_context' => [],
            ])
            ->setAllowedTypes('class', ['null', 'string'])
            ->setAllowedTypes('data_path', ['null', 'string'])
            ->setAllowedTypes('denormalize', 'bool')
            ->setAllowedTypes('denormalization_context', 'array');
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
         * @var null|string $class
         * @var null|string $dataPath
         */
        $class = $context['class'];
        $dataPath = $context['data_path'];

        if (null === $class) {
            return;
        }

        if (null === $dataPath) {
            $dataToDenormalize = &$data;
        } else {
            $dataToDenormalize = &$data[$dataPath];
        }

        $supports = $this->denormalizer
            ->supportsDenormalization($dataToDenormalize, $class, null, $context['denormalization_context']);

        if ($supports) {
            $dataToDenormalize = $this->denormalizer
                ->denormalize($dataToDenormalize, $class, null, $context['denormalization_context']);
            $event->setData($data);
        }
    }
}
