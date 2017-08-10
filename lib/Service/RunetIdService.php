<?php

namespace RunetId\ApiClient\Service;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Ruvents\AbstractApiClient\Exception\ApiException;
use Ruvents\AbstractApiClient\Service;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RunetIdService implements Service\ServiceInterface
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
        $endpointNormalizer = function (Options $context, $endpoint) {
            return '/'.ltrim($endpoint, '/');
        };

        $resolver
            ->setRequired([
                'endpoint',
                'key',
                'secret',
            ])
            ->setDefaults([
                'body' => null,
                'headers' => [],
                'host' => 'api.runet-id.com',
                'language' => 'ru',
                'method' => 'GET',
                'query' => [],
                'scheme' => 'http',
            ])
            ->setDefined('event_id')
            ->setAllowedTypes('endpoint', 'string')
            ->setAllowedTypes('key', 'string')
            ->setAllowedTypes('secret', 'string')
            ->setAllowedTypes('body', ['null', 'string', 'array', 'Psr\Http\Message\StreamInterface'])
            ->setAllowedTypes('event_id', 'int')
            ->setAllowedTypes('headers', 'array')
            ->setAllowedTypes('host', 'string')
            ->setAllowedValues('language', ['ru', 'en'])
            ->setAllowedTypes('method', 'string')
            ->setAllowedTypes('query', 'array')
            ->setAllowedTypes('scheme', 'string')
            ->setNormalizer('endpoint', $endpointNormalizer);
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(array $context)
    {
        $query = array_replace([
            'Language' => $context['language'],
        ], $context['query']);

        if (isset($context['event_id'])) {
            $query['EventId'] = $context['event_id'];
        }

        $query = $this->httpBuildQuery($query);

        $headers = array_replace([
            'Apikey' => $context['key'],
            'Timestamp' => $timestamp = time(),
            'Hash' => substr(md5($context['key'].$timestamp.$context['secret']), 0, 16),
        ], $context['headers']);

        $body = $context['body'];

        if (is_array($body)) {
            $body = $this->httpBuildQuery($context['body']);
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        return $this->requestFactory->createRequest(
            $context['method'],
            $context['scheme'].'://'.$context['host'].$context['endpoint'].'?'.$query,
            $headers,
            $body
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

        $message = isset($data['Error']['Message']) ? $data['Error']['Message'] : 'Ошибка';
        $code = isset($data['Error']['Code']) ? $data['Error']['Code'] : 0;

        throw new ApiException($context, $message, $code);
    }

    /**
     * @param array $data
     *
     * @return string
     */
    private function httpBuildQuery(array $data)
    {
        return http_build_query($data, '', '&');
    }
}
