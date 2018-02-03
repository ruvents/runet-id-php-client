<?php

namespace RunetId\Client;

use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;
use Http\Message\UriFactory;
use Psr\Http\Message\UriInterface;
use RunetId\Client\HttpClient\RunetIdAuthentication;

final class RunetIdClientFactory
{
    const DEFAULT_URI = 'http://api.runet-id.com';

    private $httpClient;
    private $uriFactory;
    private $requestFactory;
    private $streamFactory;

    public function __construct(HttpClient $httpClient = null, UriFactory $uriFactory = null, RequestFactory $requestFactory = null, StreamFactory $streamFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->uriFactory = $uriFactory ?: UriFactoryDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
        $this->streamFactory = $streamFactory ?: StreamFactoryDiscovery::find();
    }

    /**
     * @param string              $key
     * @param string              $secret
     * @param string|UriInterface $defaultUri
     * @param Plugin[]            $plugins
     * @param null|HttpClient     $httpClient
     *
     * @throws NotFoundException When Discovery fails to find a factory
     * @throws \LogicException   When invalid $defaultUri
     *
     * @return RunetIdClient
     */
    public function create($key, $secret, $defaultUri = self::DEFAULT_URI, array $plugins = [], HttpClient $httpClient = null)
    {
        $defaultUri = $this->uriFactory->createUri($defaultUri);
        parse_str($defaultUri->getQuery(), $queryDefaults);

        $plugins = array_merge([
            new Plugin\BaseUriPlugin($defaultUri),
            new Plugin\QueryDefaultsPlugin($queryDefaults),
            new Plugin\AuthenticationPlugin(new RunetIdAuthentication($key, $secret)),
            new Plugin\ErrorPlugin(),
        ], $plugins);

        $httpClient = new PluginClient($httpClient ?: $this->httpClient, $plugins);

        return new RunetIdClient($httpClient, $this->requestFactory, $this->streamFactory);
    }
}
