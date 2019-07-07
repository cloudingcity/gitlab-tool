<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Api\Response;
use App\Api\Standalone\Version;
use Mockery as m;
use Tests\TestCase;

class VersionCommandTest extends TestCase
{
    public function testVersionCommand()
    {
        $response = m::mock(Response::class);
        $response->shouldReceive('getData')
            ->andReturn(['version' => 123]);

        $version = m::mock(Version::class);
        $version->shouldReceive('execute')
            ->andReturn($response);

        $this->app->instance(Version::class, $version);

        $this->artisan('version')->assertExitCode(0);
    }
}
