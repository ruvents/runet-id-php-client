<?php

namespace RunetId\ApiClient\HttpClient;

use GuzzleHttp\Client;
use RunetId\ApiClient\App;
use RunetId\ApiClient\Request;
use RunetId\ApiClient\Response;

/**
 * Class Guzzle
 * @package RunetId\ApiClient\HttpClient
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @inheritdoc
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->client = new Client();
    }

    /**
     * @inheritdoc
     */
    public function sendRequest(Request $request)
    {
        if ($request->isPost()) {
            $result = $this->client->post($request->getUri(), [
                'query' => $request->getQuery(),
                'form_params' => $request->getData(),
                'headers' => $request->getHeaders(),
            ]);
        } else {
            $result = $this->client->get($request->getUri(), [
                'query' => array_merge($request->getQuery(), $request->getData()),
                'headers' => $request->getHeaders(),
            ]);
        }

        return new Response(
            (string)$result->getBody(),
            $result->getHeaders(),
            $result->getStatusCode()
        );
    }
}
