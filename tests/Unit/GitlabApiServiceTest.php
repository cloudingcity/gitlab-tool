<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\GitlabApiService;
use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class GitlabApiServiceTest extends TestCase
{
    use UsesGuzzler;

    public function testFetchMergeRequests()
    {
        $response = [1, 2, 3];
        $state = 'pikachu';

        $this->guzzler->queueResponse(new Response(200, [], json_encode($response)));
        $client = $this->guzzler->getClient(['base_uri' => 'http://foo']);

        $this->app->instance('gitlab.client', $client);

        $service = new GitlabApiService();
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

        $this->app->instance('gitlab.client', $client);

        $service = new GitlabApiService();
        $service->lintCi($content);

        $this->guzzler->expects($this->once())
            ->post('http://foo/api/v4/ci/lint')
            ->withBody($content);
    }
}
