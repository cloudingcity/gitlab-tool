<?php
declare(strict_types=1);

namespace Tests\Feature;

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
        $file = base_path('README.md');

        $lint = m::mock(Lint::class);
        $lint->shouldReceive('execute')
            ->with(['content' => file_get_contents($file)])
            ->andReturn((object) ['status' => 'invalid', 'errors' => ['foo', 'bar']]);
        $this->app->instance(Lint::class, $lint);

        $this->artisan('lint', ['file' => $file])
            ->assertExitCode(0);
    }

    public function testLintSuccess()
    {
        $file = base_path('README.md');

        $lint = m::mock(Lint::class);
        $lint->shouldReceive('execute')
            ->with(['content' => file_get_contents($file)])
            ->andReturn((object) ['status' => 'valid']);
        $this->app->instance(Lint::class, $lint);

        $this->artisan('lint', ['file' => $file])
            ->assertExitCode(0);
    }
}
