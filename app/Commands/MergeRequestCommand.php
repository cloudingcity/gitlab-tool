<?php

namespace App\Commands;

use App\Services\ApiService;
use LaravelZero\Framework\Commands\Command;

class MergeRequestCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'mr
                            {--state=opened : Can be opened, closed, locked, or merged.}';

    /**
     * @var string
     */
    protected $description = 'List merge requests.';

    /**
     * @param \App\Services\ApiService $gitlab
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(ApiService $gitlab)
    {
        $this->renderTable(
            $gitlab->fetchMergeRequests($this->option('state'))
        );
    }

    /**
     * @param array $items
     */
    protected function renderTable(array $items)
    {
        foreach ($items as $item) {
            [, , , $vendor, $repository] = explode('/', $item->web_url);

            $this->table(
                [$vendor, $repository],
                [
                    ['Branch', $item->source_branch],
                    ['Assignee', $item->assignee->name ?? null],
                    ['Url', $item->web_url],
                ],
                'box'
            );
        }
    }
}
