<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Services\GitlabApiService;
use Mockery as m;
use Tests\TestCase;

class GitlabMergeRequestCommandTest extends TestCase
{
    public function testMRCommand()
    {
        $service = m::mock(GitlabApiService::class);
        $service->shouldReceive('fetchMergeRequests')
            ->once()
            ->with(GitlabApiService::MERGE_REQUEST_STATE_OPENED)
            ->andReturn([
                (object) ['web_url' => 'https://example.com/foo/bar', 'source_branch' => 'baz']
            ]);
        $this->app->instance(GitlabApiService::class, $service);

        $this->artisan('gitlab:mr')
            ->assertExitCode(0);
    }
}
