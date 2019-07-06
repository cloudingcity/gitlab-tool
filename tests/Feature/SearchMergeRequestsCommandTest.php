<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Api\Standalone\Search;
use App\Factories\SearchResourceFactory;
use Mockery as m;
use Tests\TestCase;

class SearchMergeRequestsCommandTest extends TestCase
{
    public function testSearchNoResults()
    {
        $search = m::mock(Search::class);
        $search->shouldReceive('execute')
            ->with([
                'scope' => 'merge_requests',
                'search' => 'foo',
            ])
            ->andReturn([]);

        $factory = m::mock(SearchResourceFactory::class);
        $factory->shouldReceive('create')
            ->andReturn($search);

        $this->app->instance(SearchResourceFactory::class, $factory);

        $this->artisan('search:mrs', ['search' => 'foo'])
            ->expectsOutput('No results')
            ->assertExitCode(0);
    }

    public function testSearch()
    {
        $search = m::mock(Search::class);
        $search->shouldReceive('execute')
            ->with([
                'scope' => 'merge_requests',
                'search' => 'foo',
            ])
            ->andReturn([
                (object) [
                    'source_branch' => 'foo-bar',
                    'author' => (object) ['name' => 'pikachu'],
                    'state' => 'handsome',
                    'web_url' => 'https://example.com/foo/bar',
                    'merged_at' => today()->toISOString(),
                ]
            ]);

        $factory = m::mock(SearchResourceFactory::class);
        $factory->shouldReceive('create')
            ->andReturn($search);

        $this->app->instance(SearchResourceFactory::class, $factory);

        $this->artisan('search:mrs', ['search' => 'foo'])
            ->assertExitCode(0);
    }
}
