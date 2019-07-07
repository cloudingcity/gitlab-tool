<?php

namespace App\Commands;

use App\Factories\SearchResourceFactory;
use App\Helpers\Url;
use Carbon\Carbon;
use LaravelZero\Framework\Commands\Command;

class SearchMergeRequestsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'search:mrs
                            {search : The search query}
                            {--group= : The group to search in}
                            {--project= : The project to search in}';

    /**
     * @var string
     */
    protected $description = 'Search merge requests';

    /**
     * @param \App\Factories\SearchResourceFactory $factory
     * @return void
     */
    public function handle(SearchResourceFactory $factory)
    {
        $contents = $factory->create($this->options())
            ->execute([
                'scope' => 'merge_requests',
                'search' => $this->argument('search'),
            ])->getData();

        if (!$contents) {
            return $this->warn('No results');
        }

        $this->render($contents);
    }

    /**
     * @param array $items
     * @return void
     */
    protected function render(array $items)
    {
        foreach ($items as $item) {
            $this->table($this->getTableHeaders($item), $this->getTableRows($item), 'box');
        }
    }

    /**
     * @param array $item
     * @return array
     */
    protected function getTableHeaders(array $item): array
    {
        return ['Project', Url::parseProject($item['web_url'])];
    }

    /**
     * @param array $item
     * @return array
     */
    protected function getTableRows(array $item): array
    {
        $timeState = $item['merged_at'] ?
            ['Merged At', Carbon::createFromTimeString($item['merged_at'])->toDateTimeString()] :
            ['Updated At', Carbon::createFromTimeString($item['updated_at'])->toDateTimeString()];

        return [
            ['Branch', $item['source_branch']],
            ['Author', $item['author']['name']],
            ['State', $item['state']],
            $timeState,
            ['Url', $item['web_url']],
        ];
    }
}
