<?php

namespace RunetId\Client\Fixtures\HttpClient;

use GuzzleHttp\Psr7\Response;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

final class PaginatedHttpClient implements HttpClient
{
    const MAX_RESULTS_MAX = 200;

    private $items;
    private $requests = [];

    /**
     * @param int $total
     */
    public function __construct($total)
    {
        if ($total < 0) {
            throw new \InvalidArgumentException('Total must be a non-negative integer.');
        }

        $this->items = 0 === $total ? [] : range(1, $total);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request)
    {
        $this->requests[] = $request;

        parse_str($request->getUri()->getQuery(), $query);

        $pageToken = isset($query['PageToken']) ? (int) $query['PageToken'] : 0;

        $maxResults = min(
            isset($query['MaxResults']) ? (int) $query['MaxResults'] : self::MAX_RESULTS_MAX,
            self::MAX_RESULTS_MAX
        );

        return new Response(200, [], json_encode($this->getResult($pageToken, $maxResults)));
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
    private function getResult($pageToken, $maxResults)
    {
        $items = $maxResults >= 0
            ? array_slice($this->items, $pageToken, $maxResults)
            : $this->items;

        $result = [
            'Items' => $items,
        ];

        if (count($items) === $maxResults) {
            $result['NextPageToken'] = $pageToken + $maxResults;
        }

        return $result;
    }
}
