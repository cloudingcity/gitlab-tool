<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Api\Standalone\Version;
use Mockery as m;
use Tests\TestCase;

class VersionCommandTest extends TestCase
{
    public function testVersionCommand()
    {
        $version = m::mock(Version::class);
        $version->shouldReceive('execute')
            ->andReturn((object) ['version' => 123]);
        $this->app->instance(Version::class, $version);

        $this->artisan('version')
            ->assertExitCode(0);
    }
}
