<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Api\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testGetData()
    {
        $guzzleResponse = new GuzzleResponse(200, [], '{"foo":"bar"}');
        $response = new Response($guzzleResponse);

        $this->assertSame(['foo' => 'bar'], $response->getData());
    }

    public function testGetTotal()
    {
        $guzzleResponse = new GuzzleResponse(200, ['X-Total' => 123]);
        $response = new Response($guzzleResponse);

        $this->assertSame(123, $response->getTotal());
    }

    public function testGetTotalPage()
    {
        $guzzleResponse = new GuzzleResponse(200, ['X-Total-Pages' => 123]);
        $response = new Response($guzzleResponse);

        $this->assertSame(123, $response->getTotalPage());
    }

    public function testGerPerPage()
    {
        $guzzleResponse = new GuzzleResponse(200, ['X-Per-Page' => 123]);
        $response = new Response($guzzleResponse);

        $this->assertSame(123, $response->getPerPage());
    }

    public function testGetPage()
    {
        $guzzleResponse = new GuzzleResponse(200, ['X-Page' => 123]);
        $response = new Response($guzzleResponse);

        $this->assertSame(123, $response->getPage());
    }

    public function testGetNextPage()
    {
        $guzzleResponse = new GuzzleResponse(200, ['X-Next-Page' => 123]);
        $response = new Response($guzzleResponse);

        $this->assertSame(123, $response->getNextPage());
    }

    public function testGetPrevpage()
    {
        $guzzleResponse = new GuzzleResponse(200, ['X-prev-Page' => 123]);
        $response = new Response($guzzleResponse);

        $this->assertSame(123, $response->getPrevPage());
    }
}
