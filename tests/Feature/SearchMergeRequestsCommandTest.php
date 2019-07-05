<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Apis\Client;
use App\Apis\Standalone\Search;
use Mockery as m;
use Tests\TestCase;

class SearchMergeRequestsCommandTest extends TestCase
{
    public function testSearchNoResults()
    {
        $client = m::mock(Client::class);
        $client->shouldReceive('request')
            ->once()
            ->with(Search::class)
            ->andReturn([]);
        $this->app->instance(Client::class, $client);

        $this->artisan('search:mrs', ['search' => 'foo'])
            ->expectsOutput('No results')
            ->assertExitCode(0);
    }

    public function testSearch()
    {
        $client = m::mock(Client::class);
        $client->shouldReceive('request')
            ->once()
            ->with(Search::class)
            ->andReturn([
                (object) [
                    'source_branch' => 'foo-bar',
                    'author' => (object) ['name' => 'pikachu'],
                    'state' => 'handsome',
                    'web_url' => 'https://example.com/foo/bar',
                    'merged_at' => today()->toISOString(),
                ]
            ]);
        $this->app->instance(Client::class, $client);

        $this->artisan('search:mrs', ['search' => 'foo'])
            ->assertExitCode(0);
    }
}
