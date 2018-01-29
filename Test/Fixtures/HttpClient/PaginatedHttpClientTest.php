<?php

namespace RunetId\Client\Test\Fixtures\HttpClient;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

final class PaginatedHttpClientTest extends TestCase
{
    /**
     * @dataProvider getSendRequestData
     */
    public function testSendRequest($total, $maxResults, $pageToken, array $expectedItems, $expectedNextPageToken)
    {
        $client = new PaginatedHttpClient($total);

        $query = [
            'MaxResults' => $maxResults,
            'PageToken' => $pageToken,
        ];

        $request = new Request('GET', '/?'.http_build_query($query, '', '&'));
        $response = $client->sendRequest($request);
        $data = json_decode((string) $response->getBody(), true);

        $this->assertSame($expectedItems, $data['Items']);

        if (null === $expectedNextPageToken) {
            $this->assertFalse(isset($data['NextPageToken']));
        } else {
            $this->assertTrue(isset($data['NextPageToken']));
            $this->assertSame($expectedNextPageToken, $data['NextPageToken']);
        }
    }

    public function getSendRequestData()
    {
        yield [0, 5, null, [], null];
        yield [10, 0, null, [], 0];
        yield [10, 5, null, range(1, 5), 5];
        yield [10, 5, 5, range(6, 10), 10];
        yield [10, 9, null, range(1, 9), 9];
        yield [10, null, null, range(1, 10), null];
        yield [10, 400, null, range(1, 10), null];
        yield [10, 12, null, range(1, 10), null];
        yield [300, null, null, range(1, 200), 200];
        yield [300, 220, null, range(1, 200), 200];
        yield [300, 100, null, range(1, 100), 100];
        yield [300, -1, null, range(1, 300), null];
    }

    public function testGetRequests()
    {
        $client = new PaginatedHttpClient(1);

        $requests = [
            new Request('GET', '/test1'),
            new Request('GET', '/test2'),
        ];

        foreach ($requests as $request) {
            $client->sendRequest($request);
        }

        $this->assertSame($requests, $client->getRequests());
    }
}
