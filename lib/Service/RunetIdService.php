<?php

namespace RunetId\ApiClient\Service;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Ruvents\AbstractApiClient\ApiClientInterface;
use Ruvents\AbstractApiClient\Event\Events;
use Ruvents\AbstractApiClient\Event\PostDecodeEvent;
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
     * @var string[]
     */
    private static $endpointDataPaths = [
        '/event/search' => 'Users',
        '/event/users' => 'Users',
        '/pay/url' => 'Url',
    ];

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
     * @param string $endpoint
     * @param mixed  $data
     *
     * @return mixed
     */
    public static function & extractEndpointData($endpoint, &$data)
    {
        if (isset(self::$endpointDataPaths[$endpoint]) && is_array($data)) {
            return $data[self::$endpointDataPaths[$endpoint]];
        }

        return $data;
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
                'denormalize' => false,
                'extract_data' => false,
                'host' => 'api.runet-id.com',
                'iterator' => false,
                'language' => 'ru',
                'scheme' => 'http',
            ])
            ->setDefined('event_id')
            ->setAllowedTypes('denormalize', 'bool')
            ->setAllowedTypes('event_id', 'int')
            ->setAllowedTypes('extract_data', 'bool')
            ->setAllowedTypes('host', 'string')
            ->setAllowedTypes('iterator', 'bool')
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
        /** @noinspection PhpUnusedParameterInspection */
        $endpointNormalizer = function (Options $context, $endpoint) {
            return '/'.ltrim($endpoint, '/');
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
            ->setAllowedTypes('body', ['null', 'string', 'array', 'Psr\Http\Message\StreamInterface'])
            ->setAllowedTypes('endpoint', 'string')
            ->setAllowedTypes('headers', 'array')
            ->setAllowedTypes('method', 'string')
            ->setAllowedTypes('query', 'array')
            ->setNormalizer('endpoint', $endpointNormalizer);
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(array $context, ApiClientInterface $client)
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
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::POST_DECODE => ['onPostDecode', -2000],
        ];
    }

    public function onPostDecode(PostDecodeEvent $event)
    {
        $context = $event->getContext();

        if ($context['extract_data']) {
            $data = $event->getData();
            $data = self::extractEndpointData($context['endpoint'], $data);
            $event->setData($data);
        }
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
