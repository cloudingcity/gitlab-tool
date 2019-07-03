<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Apis\Client;
use App\Apis\Standalone\Version;
use Mockery as m;
use Tests\TestCase;

class VersionCommandTest extends TestCase
{
    public function testVersionCommand()
    {
        $client = m::mock(Client::class);
        $client->shouldReceive('request')
            ->with(Version::class)
            ->andReturn((object) ['version' => 123])
            ->once();
        $this->app->instance(Client::class, $client);

        $this->artisan('version')
            ->assertExitCode(0);
    }
}
