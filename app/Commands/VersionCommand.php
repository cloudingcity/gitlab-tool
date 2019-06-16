<?php

namespace App\Commands;

use App\Services\GitLabApiService;
use LaravelZero\Framework\Commands\Command;

class VersionCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'version';

    /**
     * @var string
     */
    protected $description = 'Show version information';

    /**
     * @param \App\Services\GitLabApiService $service
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(GitLabApiService $service)
    {
        $this->table(
            ['Uri', config('gitlab.uri')],
            [['Version', $service->fetchVersion()->version]],
            'box'
        );
    }
}
