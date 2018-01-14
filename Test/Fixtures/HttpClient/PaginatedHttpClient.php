<?php

namespace RunetId\Client\Test\Fixtures\HttpClient;

use GuzzleHttp\Psr7\Response;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

final class PaginatedHttpClient implements HttpClient
{
    private $total;
    private $requests = [];

    /**
     * @param int $total
     */
    public function __construct($total)
    {
        if ($total < 0) {
            throw new \InvalidArgumentException('Total must be a non-negative integer.');
        }

        $this->total = $total;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request)
    {
        $this->requests[] = $request;

        parse_str($request->getUri()->getQuery(), $query);

        $pageToken = isset($query['PageToken']) ? (int) $query['PageToken'] : 0;

        $maxResults = isset($query['MaxResults']) && is_numeric($query['MaxResults'])
            ? ($query['MaxResults'] >= 0 && $query['MaxResults'] < 200 ? (int) $query['MaxResults'] : 200)
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
        if (0 === $this->total) {
            return [
                'Items' => [],
            ];
        }

        if (0 === $maxResults) {
            return [
                'Items' => [],
                'NextPageToken' => 0,
            ];
        }

        $lastHigh = $this->total - 1;
        $high = $pageToken + $maxResults - 1;

        if ($high < $lastHigh) {
            return [
                'Items' => range($pageToken, $high),
                'NextPageToken' => $high + 1,
            ];
        }

        return [
                'Items' => range($pageToken, $lastHigh),
            ];
    }
}
