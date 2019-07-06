<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Api\Resource;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Mockery as m;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    public function testExceptionWhenMethodNotSet()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Method is not set.');

        new class extends Resource
        {
        };
    }

    public function testExceptionWhenEndpointNotSet()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Endpoint is not set.');

        new class extends Resource
        {
            protected $method = 'GET';
        };
    }

    public function testEndpointParameter()
    {
        $resource = new class (['pikachu']) extends Resource
        {
            protected $method = 'GET';
            protected $endpoint = 'foo/?/bar';

            public function getEndpoint()
            {
                return $this->endpoint;
            }
        };

        $this->assertEquals('foo/pikachu/bar', $resource->getEndpoint());
    }

    public function testEndpointParameterWithSlug()
    {
        $resource = new class (['one/two']) extends Resource
        {
            protected $method = 'GET';
            protected $endpoint = 'foo/?/bar';

            public function getEndpoint()
            {
                return $this->endpoint;
            }
        };

        $this->assertEquals('foo/one%2Ftwo/bar', $resource->getEndpoint());
    }

    public function testExecute()
    {
        $resource = new class extends Resource
        {
            protected $method = 'POST';
            protected $endpoint = 'foo/bar';
        };

        $client = m::mock(Client::class);
        $client->shouldReceive('request')
            ->with('POST', 'api/v4/foo/bar', [])
            ->andReturn(new Response());
        $this->app->instance(Client::class, $client);

        $resource->execute();
    }

    public function testExecuteGetMethod()
    {
        $resource = new class extends Resource
        {
            protected $method = 'GET';
            protected $endpoint = 'foo/bar';
        };

        $client = m::mock(Client::class);
        $client->shouldReceive('request')
            ->with('GET', 'api/v4/foo/bar', ['query' => ['foo' => 'bar']])
            ->andReturn(new Response());
        $this->app->instance(Client::class, $client);

        $resource->execute(['foo' => 'bar']);
    }

    public function testExecutePostMethod()
    {
        $resource = new class extends Resource
        {
            protected $method = 'POST';
            protected $endpoint = 'foo/bar';
        };

        $client = m::mock(Client::class);
        $client->shouldReceive('request')
            ->with('POST', 'api/v4/foo/bar', ['form_params' => ['foo' => 'bar']])
            ->andReturn(new Response());
        $this->app->instance(Client::class, $client);

        $resource->execute(['foo' => 'bar']);
    }

    public function testExecuteGetOptionsException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid method: SECRET');

        $resource = new class extends Resource
        {
            protected $method = 'SECRET';
            protected $endpoint = 'foo/bar';
        };

        $resource->execute(['foo' => 'bar']);
    }
}
