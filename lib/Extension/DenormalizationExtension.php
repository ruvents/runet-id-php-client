<?php

namespace RunetId\ApiClient\Extension;

use RunetId\ApiClient\Denormalizer\Common\AddressPreDenormalizer;
use RunetId\ApiClient\Denormalizer\Common\GeoPointPreDenormalizer;
use RunetId\ApiClient\Denormalizer\Company\CompanyPreDenormalizer;
use RunetId\ApiClient\Denormalizer\DateTimeImmutableDenormalizer;
use RunetId\ApiClient\Denormalizer\Event\EventPreDenormalizer;
use RunetId\ApiClient\Denormalizer\Event\ParticipationPreDenormalizer;
use RunetId\ApiClient\Denormalizer\Event\StatusPreDenormalizer;
use RunetId\ApiClient\Denormalizer\ModelDenormalizer;
use RunetId\ApiClient\Denormalizer\Pay\ItemListPreDenormalizer;
use RunetId\ApiClient\Denormalizer\Pay\ItemPreDenormalizer;
use RunetId\ApiClient\Denormalizer\Pay\OrderAwareItemDenormalizer;
use RunetId\ApiClient\Denormalizer\Pay\OrderPreDenormalizer;
use RunetId\ApiClient\Denormalizer\Pay\ProductPreDenormalizer;
use RunetId\ApiClient\Denormalizer\User\UserPreDenormalizer;
use RunetId\ApiClient\Denormalizer\User\WorkPreDenormalizer;
use RunetId\ApiClient\Service\RunetIdService;
use Ruvents\AbstractApiClient\Event\Events;
use Ruvents\AbstractApiClient\Event\PostDecodeEvent;
use Ruvents\AbstractApiClient\Extension\ExtensionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
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
        '/event/roles' => 'RunetId\ApiClient\Model\Event\Status[]',
        '/event/search' => 'RunetId\ApiClient\Model\User\User[]',
        '/event/users' => 'RunetId\ApiClient\Model\User\User[]',
        '/pay/list' => 'RunetId\ApiClient\Model\Pay\ItemList',
        '/pay/products' => 'RunetId\ApiClient\Model\Pay\Product[]',
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

    public function __construct(DenormalizerInterface $denormalizer = null)
    {
        $this->denormalizer = $denormalizer
            ?: new Serializer([
                new ArrayDenormalizer(),
                new DateTimeImmutableDenormalizer(),
                new OrderAwareItemDenormalizer(),
                new ModelDenormalizer(),
                new UserPreDenormalizer(),
                new ParticipationPreDenormalizer(),
                new StatusPreDenormalizer(),
                new WorkPreDenormalizer(),
                new CompanyPreDenormalizer(),
                new EventPreDenormalizer(),
                new ItemListPreDenormalizer(),
                new ItemPreDenormalizer(),
                new ProductPreDenormalizer(),
                new OrderPreDenormalizer(),
                new AddressPreDenormalizer(),
                new GeoPointPreDenormalizer(),
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureDefaultContext(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'denormalization_context' => [],
                'denormalize' => true,
                'extract_data' => true,
            ])
            ->setAllowedTypes('denormalization_context', 'array');
    }

    /**
     * {@inheritdoc}
     */
    public function configureRequestContext(OptionsResolver $resolver)
    {
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

        if (!$context['denormalize']) {
            return;
        }

        if (isset(self::$endpointClasses[$endpoint = $context['endpoint']])) {
            $data = $event->getData();

            $extractedData = &RunetIdService::extractEndpointData($endpoint, $data);

            $extractedData = $this->denormalizer->denormalize($extractedData, self::$endpointClasses[$endpoint], JsonEncoder::FORMAT, $context['denormalization_context']);

            $event->setData($data);
        }
    }
}
