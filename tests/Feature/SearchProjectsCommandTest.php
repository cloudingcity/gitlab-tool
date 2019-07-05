<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Api\Client;
use App\Api\Standalone\Search;
use Mockery as m;
use Tests\TestCase;

class SearchProjectsCommandTest extends TestCase
{
    public function testSearchNoResults()
    {
        $client = m::mock(Client::class);
        $client->shouldReceive('request')
            ->once()
            ->with(Search::class)
            ->andReturn([]);
        $this->app->instance(Client::class, $client);

        $this->artisan('search:projects', ['search' => 'foo'])
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
                    'path_with_namespace' => 'foo/bar',
                    'description' => 'foo',
                    'web_url' => 'https://example.com/foo/bar',
                    'last_activity_at' => today()->toISOString(),
                ]
            ]);
        $this->app->instance(Client::class, $client);

        $this->artisan('search:projects', ['search' => 'foo'])
            ->assertExitCode(0);
    }
}
