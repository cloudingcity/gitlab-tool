<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Services\GitLabApiService;
use Mockery as m;
use Tests\TestCase;

class MergeRequestCommandTest extends TestCase
{
    public function testMRCommand()
    {
        $service = m::mock(GitLabApiService::class);
        $service->shouldReceive('fetchMergeRequests')
            ->once()
            ->with('opened')
            ->andReturn([
                (object) ['web_url' => 'https://example.com/foo/bar', 'source_branch' => 'baz']
            ]);
        $this->app->instance(GitLabApiService::class, $service);

        $this->artisan('mr')
            ->assertExitCode(0);
    }
}
