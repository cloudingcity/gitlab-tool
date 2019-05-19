<?php

namespace App\Commands;

use App\Services\GitlabApiService;
use LaravelZero\Framework\Commands\Command;

class MergeRequestGitlabCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'gitlab:merge-request
                            {--state=opened : Can be opened, closed, locked, or merged.}';

    /**
     * @var string
     */
    protected $description = 'List merge requests.';

    /**
     * @param \App\Services\GitlabApiService $gitlab
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(GitlabApiService $gitlab)
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
