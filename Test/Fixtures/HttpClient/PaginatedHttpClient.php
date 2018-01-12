<?php

namespace RunetId\Client\Test\Fixtures\HttpClient;

use GuzzleHttp\Psr7\Response;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

final class PaginatedHttpClient implements HttpClient
{
    private $offset;
    private $total;
    private $items;
    private $requests = [];

    /**
     * @param string $offset
     * @param int    $total
     */
    public function __construct($offset, $total)
    {
        $this->offset = $offset;
        $this->total = $total;
        $this->items = range(1, $total);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request)
    {
        $this->requests[] = $request;

        parse_str($request->getUri()->getQuery(), $query);

        $pageToken = isset($query['PageToken']) ? (int) $query['PageToken'] : 0;

        $maxResults = isset($query['MaxResults'])
            ? ($query['MaxResults'] < 200
                ? (int) $query['MaxResults']
                : 200)
            : 200;

        return new Response(200, [], json_encode($this->getData($pageToken, $maxResults)));
    }

    /**
     * @return RequestInterface[]
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * @param int $pageToken
     * @param int $maxResults
     *
     * @return array
     */
    private function getData($pageToken, $maxResults)
    {
        return [
            $this->offset => array_slice($this->items, $pageToken, $maxResults),
            'NextPageToken' => ($token = $pageToken + $maxResults) >= $this->total ? null : $token,
        ];
    }
}
