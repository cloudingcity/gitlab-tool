<?php

namespace App\Commands;

use App\Api\Standalone\Version;
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
     * @return void
     */
    public function handle()
    {
        $response = app(Version::class)->execute();
        $version = $response->getData()['version'];

        $this->table(
            ['Uri', config('gitlab.uri')],
            [['Version', $version]],
            'box'
        );
    }
}
