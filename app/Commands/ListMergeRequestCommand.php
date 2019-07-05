<?php

namespace App\Commands;

use App\Api\Client;
use App\Api\Standalone\MergeRequests;
use App\Helpers\Url;
use Illuminate\Support\Carbon;
use LaravelZero\Framework\Commands\Command;

class ListMergeRequestCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'list:mrs
                            {--state=opened : Can be opened, closed, locked, or merged}';

    /**
     * @var string
     */
    protected $description = 'List merge requests created by you';

    /**
     * @param \App\Api\Client $client
     * @return void
     */
    public function handle(Client $client)
    {
        $resource = (new MergeRequests())->query([
            'state' => $this->option('state'),
            'order_by' => 'updated_at',
            'sort' => 'asc',
        ]);

        $this->render($client->request($resource));
    }

    /**
     * @param array $items
     * @return void
     */
    protected function render(array $items)
    {
        foreach ($items as $item) {
            $updatedAt = Carbon::createFromTimeString($item->updated_at)->toDateTimeString();

            $this->table(
                ['Project', Url::parseProject($item->web_url)],
                [
                    ['Branch', $item->source_branch],
                    ['Assignee', $item->assignee->name ?? null],
                    ['Updated At', $updatedAt],
                    ['Url', $item->web_url],
                ],
                'box'
            );
        }
    }
}
