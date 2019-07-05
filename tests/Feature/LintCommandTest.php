<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Api\Client;
use App\Api\Standalone\Lint;
use Mockery as m;
use Tests\TestCase;

class LintCommandTest extends TestCase
{
    public function testFileNotFound()
    {
        $this->artisan('lint', ['file' => 'foo'])
            ->assertExitCode(0);
    }

    public function testLintError()
    {
        $this->mockClient(['status' => 'invalid', 'errors' => ['foo', 'bar']]);

        $this->artisan('lint', ['file' => base_path('README.md')])
            ->assertExitCode(0);
    }

    public function testLintSuccess()
    {
        $this->mockClient(['status' => 'valid']);

        $this->artisan('lint', ['file' => base_path('README.md')])
            ->assertExitCode(0);
    }

    protected function mockClient(array $responses)
    {
        $service = m::mock(Client::class);
        $service->shouldReceive('request')
            ->with(Lint::class)
            ->andReturn((object) $responses)
            ->once();

        $this->app->instance(Client::class, $service);
    }
}
