<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Api\Response;
use App\Api\Standalone\MergeRequests;
use App\Factories\MergeRequestsResourceFactory;
use Mockery as m;
use Tests\TestCase;

class ListMergeRequestCommandTest extends TestCase
{
    public function testMRCommand()
    {
        $response = m::mock(Response::class);
        $response->shouldReceive('getPage');
        $response->shouldReceive('getTotalPage');
        $response->shouldReceive('getPerPage');
        $response->shouldReceive('getTotal');
        $response->shouldReceive('getData')
            ->andReturn([
                [
                    'web_url' => 'https://example.com/foo/bar',
                    'source_branch' => 'baz',
                    'updated_at' => today()->toISOString(),
                ]
            ]);

        $mergeRequest = m::mock(MergeRequests::class);
        $mergeRequest->shouldReceive('execute')
            ->with([
                'state' => 'opened',
                'scope' => 'created_by_me',
                'order_by' => 'updated_at',
                'sort' => 'asc',
            ])
            ->andReturn($response);

        $factory = m::mock(MergeRequestsResourceFactory::class);
        $factory->shouldReceive('create')
            ->andReturn($mergeRequest);

        $this->app->instance(MergeRequestsResourceFactory::class, $factory);

        $this->artisan('list:mrs')
            ->assertExitCode(0);
    }
}
