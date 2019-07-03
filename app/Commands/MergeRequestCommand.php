<?php

namespace App\Commands;

use App\Apis\Client;
use App\Apis\Standalone\MergeRequests;
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
     * @param \App\Apis\Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        $resource = (new MergeRequests())->query(['state' => $this->option('state')]);

        $this->render($client->request($resource));
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
