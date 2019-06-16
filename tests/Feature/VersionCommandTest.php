<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Services\ApiService;
use Mockery as m;
use Tests\TestCase;

class VersionCommandTest extends TestCase
{
    public function testVersionCommand()
    {
        $service = m::mock(ApiService::class);
        $service->shouldReceive('fetchVersion')->andReturn((object) ['version' => 123])->once();

        $this->app->instance(ApiService::class, $service);

        $this->artisan('version')
            ->assertExitCode(0);
    }
}
