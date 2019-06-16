<?php

namespace App\Commands;

use App\Services\GitLabApiService;
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
     * @param \App\Services\GitLabApiService $gitlab
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(GitLabApiService $gitlab)
    {
        $this->render(
            $gitlab->fetchMergeRequests($this->option('state'))
        );
    }

    /**
     * @param array $items
     * @return void
     */
    protected function render(array $items)
    {
        foreach ($items as $item) {
            [, , , $vendor, $repository] = explode('/', $item->web_url);

            $this->table(
                ['Project', $vendor . '/' . $repository],
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
