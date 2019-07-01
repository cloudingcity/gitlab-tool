<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Apis\Client;
use App\Apis\Resource;
use App\Exceptions\ApiException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery as m;
use Tests\TestCase;

class ClientTest extends TestCase
{
    public function testRequest()
    {
        $guzzleClient = m::mock(GuzzleClient::class);
        $guzzleClient->shouldReceive('request')
            ->with('GET', 'api/v4/foo/bar', ['query' => ['foo' => 'bar'], 'form_params' => ['foo' => 'bar']])
            ->andReturn(new Response());

        $resource = m::mock(Resource::class);
        $resource->shouldReceive('all')
            ->andReturn([
                'method' => 'GET',
                'endpoint' => 'foo/bar',
                'query' => ['foo' => 'bar'],
                'body' => ['foo' => 'bar'],
            ]);

        $client = new Client($guzzleClient);
        $client->request($resource);
    }

    public function testRequestApiException()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Error Communicating with Server');

        $mock = new MockHandler([
            new RequestException('Error Communicating with Server', new Request('GET', 'foo')),
        ]);
        $handler = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient(['handler' => $handler]);

        $resource = m::mock(Resource::class);
        $resource->shouldReceive('all')
            ->andReturn([
                'method' => 'GET',
                'endpoint' => 'foo/bar',
                'query' => [],
                'body' => [],
            ]);

        $client = new Client($guzzleClient);
        $client->request($resource);
    }
}
