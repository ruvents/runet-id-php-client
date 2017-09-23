<?php

namespace RunetId\ApiClient\Service;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use RunetId\ApiClient\Exception\RunetIdException;
use RunetId\ApiClient\Result\ResultDenormalizer;
use Ruvents\AbstractApiClient\ApiClientInterface;
use Ruvents\AbstractApiClient\Event\ApiEvents;
use Ruvents\AbstractApiClient\Event\PostDecodeEvent;
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
        $hostNormalizer = function (
            /** @noinspection PhpUnusedParameterInspection */
            Options $context,
            $host
        ) {
            return rtrim($host, '/');
        };

        $resolver
            ->setRequired([
                'key',
                'secret',
            ])
            ->setDefaults([
                'event_id' => null,
                'host' => 'http://api.runet-id.com',
                'language' => 'ru',
            ])
            ->setAllowedTypes('event_id', ['null', 'int'])
            ->setAllowedTypes('host', 'string')
            ->setAllowedTypes('key', 'string')
            ->setAllowedTypes('secret', 'string')
            ->setAllowedValues('language', ['ru', 'en'])
            ->setNormalizer('host', $hostNormalizer);
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

        $resolver
            ->setRequired([
                'endpoint',
                'method',
            ])
            ->setDefaults([
                'body' => null,
                'class' => null,
                'data' => [],
                'headers' => [],
                'max_results' => null,
                'prevent_decode' => false,
                'query' => [],
                'request_paginated_data' => true,
            ])
            ->setDefined([
                'paginated_data_offset',
            ])
            ->setAllowedTypes('body', ['null', 'string', 'Psr\Http\Message\StreamInterface'])
            ->setAllowedTypes('class', ['null', 'string'])
            ->setAllowedTypes('data', 'array')
            ->setAllowedTypes('endpoint', 'string')
            ->setAllowedTypes('headers', 'array')
            ->setAllowedTypes('max_results', ['null', 'int'])
            ->setAllowedTypes('paginated_data_offset', 'string')
            ->setAllowedTypes('prevent_decode', 'bool')
            ->setAllowedTypes('query', 'array')
            ->setAllowedTypes('request_paginated_data', 'bool')
            ->setAllowedValues('method', ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE'])
            ->setNormalizer('endpoint', $endpointNormalizer);
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(array $context, ApiClientInterface $client)
    {
        $query = array_replace([
            'EventId' => $context['event_id'],
            'Language' => $context['language'],
            'MaxResults' => $context['max_results'],
        ], $context['query']);

        $headers = array_replace([
            'Apikey' => $context['key'],
            'Timestamp' => $timestamp = time(),
            'Hash' => substr(md5($context['key'].$timestamp.$context['secret']), 0, 16),
        ], $context['headers']);

        $body = $context['body'];

        if (null === $context['body'] && [] !== $context['data']) {
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
            $context['host'].$context['endpoint'].'?'.$query,
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
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ApiEvents::POST_DECODE => [
                ['preventDecode', 1000],
                ['requestPaginatedData', 950],
                ['denormalize', -100],
            ],
        ];
    }

    /**
     * @param PostDecodeEvent $event
     */
    public function preventDecode(PostDecodeEvent $event)
    {
        if ($event->getContext()['prevent_decode']) {
            $event->stopPropagation();
        }
    }

    /**
     * @param PostDecodeEvent $event
     */
    public function requestPaginatedData(PostDecodeEvent $event)
    {
        $context = $event->getContext();
        $data = $event->getResponseData();

        if (!$context['request_paginated_data'] || !is_array($data)) {
            return;
        }

        $resultData = $data;

        while (false !== $this->prepareNextPageContext($data, $context)) {
            $data = $event->getClient()->request($context);
            $resultData[$context['paginated_data_offset']] = array_merge(
                $resultData[$context['paginated_data_offset']],
                $data[$context['paginated_data_offset']]
            );
        }

        $event->setResponseData($resultData);
    }

    /**
     * @param PostDecodeEvent $event
     */
    public function denormalize(PostDecodeEvent $event)
    {
        $context = $event->getContext();

        if (!isset($context['class'])) {
            return;
        }

        $data = ResultDenormalizer::denormalize($event->getResponseData(), $context['class']);
        $event->setResponseData($data);
    }

    /**
     * @param array $previousData
     * @param array $context
     *
     * @return bool
     */
    private function prepareNextPageContext(array $previousData, array &$context)
    {
        if (!isset($context['max_results']) || !isset($context['paginated_data_offset']) || !isset($previousData['NextPageToken'])) {
            return false;
        }

        $context['max_results'] -= count($previousData[$context['paginated_data_offset']]);

        if ($context['max_results'] <= 0) {
            return false;
        }

        $context['prevent_decode'] = true;
        $context['query']['PageToken'] = $previousData['NextPageToken'];

        return true;
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
