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
