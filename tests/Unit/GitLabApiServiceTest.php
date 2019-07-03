<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\GitLabApiService;
use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class GitLabApiServiceTest extends TestCase
{
    use UsesGuzzler;

    public function testFetchMergeRequests()
    {
        $state = 'pikachu';

        $this->guzzler->queueResponse(new Response(200, [], json_encode([1, 2, 3])));
        $client = $this->guzzler->getClient(['base_uri' => 'http://foo']);

        $service = new GitLabApiService($client);
        $mergeRequests = $service->fetchMergeRequests($state);

        $this->guzzler->expects($this->once())
            ->get('http://foo/api/v4/merge_requests')
            ->withQuery(['state' => $state]);

        $this->assertSame($mergeRequests, [1, 2, 3]);
    }

    public function testLintCi()
    {
        $content = 'pikachu';

        $this->guzzler->queueResponse(new Response(200, [], json_encode(['foo' => 'bar'])));
        $client = $this->guzzler->getClient(['base_uri' => 'http://foo']);

        $service = new GitLabApiService($client);
        $service->lintCi($content);

        $this->guzzler->expects($this->once())
            ->post('http://foo/api/v4/ci/lint')
            ->withBody($content);
    }
    public function testSearchProjects()
    {
        $this->guzzler->queueResponse(new Response(200, [], json_encode([])));
        $client = $this->guzzler->getClient(['base_uri' => 'http://foo']);

        $service = new GitLabApiService($client);
        $service->searchProjects('foo');

        $this->guzzler->expects($this->once())
            ->get('http://foo/api/v4/search')
            ->withQuery(['scope' => 'projects', 'search' => 'foo']);
    }

    public function testSearchProjectsWithGroup()
    {
        $this->guzzler->queueResponse(new Response(200, [], json_encode([])));
        $client = $this->guzzler->getClient(['base_uri' => 'http://foo']);

        $service = new GitLabApiService($client);
        $service->searchProjects('foo', 'bar');

        $this->guzzler->expects($this->once())
            ->get('http://foo/api/v4/groups/bar/search')
            ->withQuery(['scope' => 'projects', 'search' => 'foo']);
    }
}
