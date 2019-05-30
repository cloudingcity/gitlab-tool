<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Services\ApiService;
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
        $this->mockService(['status' => 'invalid', 'errors' => ['foo', 'bar']]);

        $this->artisan('lint', ['file' => base_path('README.md')])
            ->assertExitCode(0);
    }

    public function testLintSuccess()
    {
        $this->mockService(['status' => 'valid']);

        $this->artisan('lint', ['file' => base_path('README.md')])
            ->assertExitCode(0);
    }

    protected function mockService(array $responses)
    {
        $service = m::mock(ApiService::class);
        $service->shouldReceive('lintCi')
            ->once()
            ->andReturn((object) $responses);
        $this->app->instance(ApiService::class, $service);
    }
}
