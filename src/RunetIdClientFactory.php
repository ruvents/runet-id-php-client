<?php

namespace RunetId\Client;

use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;
use Http\Message\UriFactory;
use Psr\Http\Message\UriInterface;
use RunetId\Client\Endpoint\QueryHelper;
use RunetId\Client\HttpClient\RunetIdAuthentication;
use RunetId\Client\OAuth\OAuthUriGenerator;

final class RunetIdClientFactory
{
    const API_URI = 'http://api.runet-id.com';
    const OAUTH_URI = 'https://runet-id.com/oauth/main/dialog';

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
     * @param string                   $key
     * @param string                   $secret
     * @param null|string|UriInterface $apiUri
     * @param null|string|UriInterface $oauthUri
     * @param Plugin[]                 $plugins
     * @param null|HttpClient          $httpClient
     *
     * @return RunetIdClient
     */
    public function create(
        $key,
        $secret,
        $apiUri = null,
        $oauthUri = null,
        array $plugins = [],
        HttpClient $httpClient = null
    ) {
        $apiUri = $this->uriFactory->createUri($apiUri ?: self::API_URI);
        $oauthUri = $this->uriFactory->createUri($oauthUri ?: self::OAUTH_URI);
        $oauthUriGenerator = new OAuthUriGenerator($oauthUri, $key);

        $plugins = array_merge([
            new Plugin\BaseUriPlugin($apiUri),
            new Plugin\QueryDefaultsPlugin((new QueryHelper($apiUri->getQuery()))->getData()),
            new Plugin\AuthenticationPlugin(new RunetIdAuthentication($key, $secret)),
            new Plugin\ErrorPlugin(),
        ], $plugins);

        $httpClient = new PluginClient($httpClient ?: $this->httpClient, $plugins);

        return new RunetIdClient($oauthUriGenerator, $httpClient, $this->requestFactory, $this->streamFactory);
    }
}
