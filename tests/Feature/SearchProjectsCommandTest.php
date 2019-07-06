<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Api\Standalone\Search;
use App\Factories\SearchResourceFactory;
use Mockery as m;
use Tests\TestCase;

class SearchProjectsCommandTest extends TestCase
{
    public function testSearchNoResults()
    {
        $search = m::mock(Search::class);
        $search->shouldReceive('execute')
            ->with([
                'scope' => 'projects',
                'search' => 'foo',
            ])
            ->andReturn([]);

        $factory = m::mock(SearchResourceFactory::class);
        $factory->shouldReceive('create')
            ->andReturn($search);

        $this->app->instance(SearchResourceFactory::class, $factory);

        $this->artisan('search:projects', ['search' => 'foo'])
            ->expectsOutput('No results')
            ->assertExitCode(0);
    }

    public function testSearch()
    {

        $search = m::mock(Search::class);
        $search->shouldReceive('execute')
            ->with([
                'scope' => 'projects',
                'search' => 'foo',
            ])
            ->andReturn([
                (object) [
                    'path_with_namespace' => 'foo/bar',
                    'description' => 'foo',
                    'web_url' => 'https://example.com/foo/bar',
                    'last_activity_at' => today()->toISOString(),
                ]
            ]);

        $factory = m::mock(SearchResourceFactory::class);
        $factory->shouldReceive('create')
            ->andReturn($search);

        $this->app->instance(SearchResourceFactory::class, $factory);

        $this->artisan('search:projects', ['search' => 'foo'])
            ->assertExitCode(0);
    }
}
