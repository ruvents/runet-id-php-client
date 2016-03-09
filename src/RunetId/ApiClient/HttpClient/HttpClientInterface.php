<?php

namespace RunetId\ApiClient\HttpClient;

use RunetId\ApiClient\Request;
use RunetId\ApiClient\Response;

/**
 * Interface HttpClientInterface
 * @package RunetId\ApiClient
 */
interface HttpClientInterface
{
    /**
     * @param Request $request
     * @return Response
     */
    public function sendRequest(Request $request);
}
