<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Services\GitlabApiService;
use Mockery as m;
use Tests\TestCase;

class GitlabLintCommandTest extends TestCase
{
    public function testFileNotFound()
    {
        $this->artisan('gitlab:lint', ['file' => 'foo'])
            ->assertExitCode(0);
    }

    public function testLintError()
    {
        $this->mockService(['status' => 'invalid', 'errors' => ['foo', 'bar']]);

        $this->artisan('gitlab:lint', ['file' => base_path('README.md')])
            ->assertExitCode(0);
    }

    public function testLintSuccess()
    {
        $this->mockService(['status' => 'valid']);

        $this->artisan('gitlab:lint', ['file' => base_path('README.md')])
            ->assertExitCode(0);
    }

    protected function mockService(array $responses)
    {
        $service = m::mock(GitlabApiService::class);
        $service->shouldReceive('lintCi')
            ->once()
            ->andReturn((object) $responses);
        $this->app->instance(GitlabApiService::class, $service);
    }
}
