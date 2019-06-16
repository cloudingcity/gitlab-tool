<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\ApiService;
use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{
    use UsesGuzzler;

    public function testFetchMergeRequests()
    {
        $response = [1, 2, 3];
        $state = 'pikachu';

        $this->guzzler->queueResponse(new Response(200, [], json_encode($response)));
        $client = $this->guzzler->getClient(['base_uri' => 'http://foo']);

        $service = new ApiService($client);
        $mergeRequests = $service->fetchMergeRequests($state);

        $this->guzzler->expects($this->once())
            ->get('http://foo/api/v4/merge_requests')
            ->withQuery(['state' => $state]);

        $this->assertSame($mergeRequests, $response);
    }

    public function testLintCi()
    {
        $content = 'pikachu';

        $this->guzzler->queueResponse(new Response());
        $client = $this->guzzler->getClient(['base_uri' => 'http://foo']);

        $service = new ApiService($client);
        $service->lintCi($content);

        $this->guzzler->expects($this->once())
            ->post('http://foo/api/v4/ci/lint')
            ->withBody($content);
    }

    public function testFetchVersion()
    {
        $this->guzzler->queueResponse(new Response());
        $client = $this->guzzler->getClient(['base_uri' => 'http://foo']);

        $service = new ApiService($client);
        $service->fetchVersion();

        $this->guzzler->expects($this->once())
            ->get('http://foo/api/v4/version');
    }
}
