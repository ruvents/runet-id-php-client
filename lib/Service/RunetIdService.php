<?php

namespace RunetId\ApiClient\Service;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Ruvents\AbstractApiClient\Exception\ApiException;
use Ruvents\AbstractApiClient\Service;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RunetIdService implements Service\ApiServiceInterface
{
    use Service\HttpClientDiscoveryTrait;
    use Service\Response200Trait;
    use Service\JsonDecodeTrait;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    public function __construct(HttpClient $httpClient = null, RequestFactory $requestFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * {@inheritdoc}
     */
    public function configureContext(OptionsResolver $resolver)
    {
        /** @noinspection PhpUnusedParameterInspection */
        $resolver
            ->setRequired([
                'endpoint',
                'key',
                'secret',
            ])
            ->setDefaults([
                'event_id' => null,
                'get_data' => [],
                'headers' => [],
                'host' => 'api.runet-id.com',
                'language' => 'ru',
                'method' => 'GET',
                'post_data' => [],
                'scheme' => 'http',
            ])
            ->setAllowedTypes('endpoint', 'string')
            ->setAllowedTypes('key', 'string')
            ->setAllowedTypes('secret', 'string')
            ->setAllowedTypes('event_id', ['null', 'int'])
            ->setAllowedTypes('get_data', 'array')
            ->setAllowedTypes('headers', 'array')
            ->setAllowedTypes('host', 'string')
            ->setAllowedValues('language', ['ru', 'en'])
            ->setAllowedTypes('method', 'string')
            ->setAllowedTypes('post_data', 'array')
            ->setAllowedTypes('scheme', 'string')
            ->setNormalizer('endpoint', function ($context, $endpoint) {
                return '/'.ltrim($endpoint, '/');
            });
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(array $context)
    {
        $getData = array_replace([
            'EventId' => $context['event_id'],
            'Language' => $context['language'],
        ], $context['get_data']);

        $headers = array_replace([
            'Apikey' => $context['key'],
            'Timestamp' => $timestamp = time(),
            'Hash' => substr(md5($context['key'].$timestamp.$context['secret']), 0, 16),
        ], $context['headers']);

        return $this->requestFactory->createRequest(
            $context['method'],
            $context['scheme'].'://'.$context['host'].$context['endpoint'].'?'.http_build_query($getData),
            $headers,
            http_build_query($context['post_data'])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function validateData($data, array $context)
    {
        if (!isset($data['Error'])) {
            return;
        }

        $message = isset($data['Error']['Message']) ? $data['Error']['Message'] : '';
        $code = isset($data['Error']['Code']) ? $data['Error']['Code'] : 0;

        throw new ApiException($context, $message, $code);
    }
}
