<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Api\Resource;
use InvalidArgumentException;
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
        $resource = new class ('pikachu') extends Resource
        {
            protected $method = 'GET';
            protected $endpoint = 'foo/?/bar';
        };

        $this->assertEquals('foo/pikachu/bar', $resource->all()['endpoint']);
    }

    public function testEndpointParameterWithSlug()
    {
        $resource = new class ('one/two') extends Resource
        {
            protected $method = 'GET';
            protected $endpoint = 'foo/?/bar';
        };

        $this->assertEquals('foo/one%2Ftwo/bar', $resource->all()['endpoint']);
    }

    public function testQuery()
    {
        $resource = new class extends Resource
        {
            protected $method = 'GET';
            protected $endpoint = 'foo/bar';
        };

        $resource->query(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $resource->all()['query']);
    }

    public function testBody()
    {
        $resource = new class extends Resource
        {
            protected $method = 'GET';
            protected $endpoint = 'foo/bar';
        };

        $resource->body(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $resource->all()['body']);
    }

    public function testAll()
    {
        $resource = new class extends Resource
        {
            protected $method = 'GET';
            protected $endpoint = 'foo/bar';
        };

        $expected = [
            'method' => 'GET',
            'endpoint' => 'foo/bar',
            'query' => [],
            'body' => [],
        ];
        $this->assertEquals($expected, $resource->all());
    }
}
