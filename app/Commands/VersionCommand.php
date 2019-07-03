<?php

namespace App\Commands;

use App\Apis\Client;
use App\Apis\Standalone\Version;
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
     * @param \App\Apis\Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        $version = $client->request(new Version())->version;

        $this->table(
            ['Uri', config('gitlab.uri')],
            [['Version', $version]],
            'box'
        );
    }
}
