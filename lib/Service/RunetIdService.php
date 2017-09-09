<?php

namespace RunetId\ApiClient\Service;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use RunetId\ApiClient\Exception\RunetIdException;
use Ruvents\AbstractApiClient\ApiClientInterface;
use Ruvents\AbstractApiClient\Service\AbstractApiService;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RunetIdService extends AbstractApiService
{
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
    public function configureDefaultContext(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired([
                'key',
                'secret',
            ])
            ->setDefaults([
                'host' => 'api.runet-id.com',
                'language' => 'ru',
                'scheme' => 'http',
            ])
            ->setDefined('event_id')
            ->setAllowedTypes('event_id', 'int')
            ->setAllowedTypes('host', 'string')
            ->setAllowedTypes('key', 'string')
            ->setAllowedTypes('scheme', 'string')
            ->setAllowedTypes('secret', 'string')
            ->setAllowedValues('language', ['ru', 'en']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureRequestContext(OptionsResolver $resolver)
    {
        $endpointNormalizer = function (
            /** @noinspection PhpUnusedParameterInspection */
            Options $context,
            $endpoint
        ) {
            return '/'.ltrim($endpoint, '/');
        };

        $methodNormalizer = function (
            /** @noinspection PhpUnusedParameterInspection */
            Options $context,
            $method
        ) {
            return strtoupper($method);
        };

        $resolver
            ->setRequired([
                'endpoint',
            ])
            ->setDefaults([
                'body' => null,
                'headers' => [],
                'method' => 'GET',
                'query' => [],
            ])
            ->setDefined('data')
            ->setAllowedTypes('body', ['null', 'string', 'Psr\Http\Message\StreamInterface'])
            ->setAllowedTypes('data', ['null', 'array'])
            ->setAllowedTypes('endpoint', 'string')
            ->setAllowedTypes('headers', 'array')
            ->setAllowedTypes('method', 'string')
            ->setAllowedTypes('query', 'array')
            ->setNormalizer('endpoint', $endpointNormalizer)
            ->setNormalizer('method', $methodNormalizer);
        // todo: check that either body or data is set
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(array $context, ApiClientInterface $client)
    {
        $query = array_replace([
            'Language' => $context['language'],
            'EventId' => isset($context['event_id']) ? $context['event_id'] : null,
        ], $context['query']);

        $headers = array_replace([
            'Apikey' => $context['key'],
            'Timestamp' => $timestamp = time(),
            'Hash' => substr(md5($context['key'].$timestamp.$context['secret']), 0, 16),
        ], $context['headers']);

        $body = $context['body'];

        if (isset($context['data'])) {
            if ('POST' === $context['method'] || 'PUT' === $context['method']) {
                $body = $this->httpBuildQuery($context['data']);
                $headers['Content-Type'] = 'application/x-www-form-urlencoded';
            } else {
                $query = array_replace($query, $context['data']);
            }
        }

        $query = $this->httpBuildQuery($query);

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

        throw new RunetIdException($context, $message, $code);
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
