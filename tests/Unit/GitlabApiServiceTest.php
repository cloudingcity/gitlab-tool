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

        $service = new GitlabApiService($client);
        $mergeRequests = $service->fetchMergeRequests($state);

        $this->guzzler->expects($this->once())
            ->get('http://foo/merge_requests')
            ->withQuery(['author_id' => 123, 'state' => $state]);

        $this->assertSame($mergeRequests, $response);
    }
}
