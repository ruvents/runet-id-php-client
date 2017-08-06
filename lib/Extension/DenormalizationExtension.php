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
    private $classes = [
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
    private $dataPaths = [
        '/event/search' => 'Users',
        '/event/users' => 'Users',
    ];

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * @param string[]                   $classes
     * @param null|DenormalizerInterface $denormalizer
     */
    public function __construct($classes = [], DenormalizerInterface $denormalizer = null)
    {
        $this->classes = array_merge($this->classes, $classes);
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

                    return isset($this->classes[$endpoint]) ? $this->classes[$endpoint] : null;
                },
                'data_path' => function (Options $context) {
                    $endpoint = $context['endpoint'];

                    return isset($this->dataPaths[$endpoint]) ? $this->dataPaths[$endpoint] : null;
                },
                'denormalize' => true,
            ])
            ->setAllowedTypes('class', ['null', 'string'])
            ->setAllowedTypes('data_path', ['null', 'string'])
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
            $denormalizationData = &$data;
        } else {
            $denormalizationData = &$data[$dataPath];
        }

        if ($this->denormalizer->supportsDenormalization($denormalizationData, $class)) {
            $denormalizationData = $this->denormalizer->denormalize($denormalizationData, $class);
            $event->setData($data);
        }
    }
}
