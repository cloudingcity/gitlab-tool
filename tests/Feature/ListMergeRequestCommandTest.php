<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Apis\Client;
use App\Apis\Standalone\MergeRequests;
use Mockery as m;
use Tests\TestCase;

class ListMergeRequestCommandTest extends TestCase
{
    public function testMRCommand()
    {
        $client = m::mock(Client::class);
        $client->shouldReceive('request')
            ->once()
            ->with(MergeRequests::class)
            ->andReturn([
                (object) [
                    'web_url' => 'https://example.com/foo/bar',
                    'source_branch' => 'baz',
                    'updated_at' => today()->toISOString(),
                ]
            ]);
        $this->app->instance(Client::class, $client);

        $this->artisan('list:mrs')
            ->assertExitCode(0);
    }
}
