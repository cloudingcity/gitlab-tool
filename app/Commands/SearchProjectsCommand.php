<?php

namespace App\Commands;

use App\Services\GitLabApiService;
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
     * @param \App\Services\GitLabApiService $service
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(GitLabApiService $service)
    {
        $result = $service->searchProjects($this->argument('search'), $this->option('group'));

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
