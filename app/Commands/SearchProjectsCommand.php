<?php

namespace App\Commands;

use App\Apis\Client;
use App\Apis\Group\Search as GroupSearch;
use App\Apis\Standalone\Search;
use Carbon\Carbon;
use LaravelZero\Framework\Commands\Command;

class SearchProjectsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'search:projects
                            {search : The search query}
                            {--group= : The group to search in}';

    /**
     * @var string
     */
    protected $description = 'Search projects';

    /**
     * @param \App\Apis\Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        $resource = $this->option('group') ? new GroupSearch($this->option('group')) : new Search();
        $resource->query([
            'scope' => 'projects',
            'search' => $this->argument('search'),
        ]);
        $result = $client->request($resource);

        if (!$result) {
            return $this->warn('No results');
        }

        $this->render($result);
    }

    /**
     * @param array $items
     * @return void
     */
    protected function render(array $items)
    {
        foreach ($items as $item) {
            $updatedAt = Carbon::createFromTimeString($item->last_activity_at)->toDateTimeString();

            $this->table(
                ['Project', $item->path_with_namespace],
                [
                    $item->description ? ['Description', $item->description] : [],
                    ['Url', $item->web_url],
                    ['Updated At', $updatedAt],
                ],
                'box'
            );
        }
    }
}
