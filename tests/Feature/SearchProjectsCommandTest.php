<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Services\GitLabApiService;
use Mockery as m;
use Tests\TestCase;

class SearchProjectsCommandTest extends TestCase
{
    public function testSearchNoResults()
    {
        $service = m::mock(GitLabApiService::class);
        $service->shouldReceive('searchProjects')
            ->once()
            ->with('foo', false)
            ->andReturn([]);
        $this->app->instance(GitLabApiService::class, $service);

        $this->artisan('search:projects', ['search' => 'foo'])
            ->expectsOutput('No results')
            ->assertExitCode(0);
    }

    public function testSearch()
    {
        $service = m::mock(GitLabApiService::class);
        $service->shouldReceive('searchProjects')
            ->once()
            ->with('foo', 'bar')
            ->andReturn([
                (object) [
                    'path_with_namespace' => 'foo/bar',
                    'description' => 'foo',
                    'web_url' => 'https://example.com/foo/bar',
                    'last_activity_at' => today()->toISOString(),
                ]
            ]);
        $this->app->instance(GitLabApiService::class, $service);

        $this->artisan('search:projects', ['search' => 'foo', '--group' => 'bar'])
            ->assertExitCode(0);
    }
}
