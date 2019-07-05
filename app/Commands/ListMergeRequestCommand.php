<?php

namespace App\Commands;

use App\Api\Client;
use App\Factories\MergeRequestsResourceFactory;
use App\Helpers\Url;
use Illuminate\Support\Carbon;
use LaravelZero\Framework\Commands\Command;

class ListMergeRequestCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'list:mrs
                            {--state=opened : Can be opened, closed, locked, or merged}
                            {--group= : The group to search in}
                            {--project= : The project to search in}';

    /**
     * @var string
     */
    protected $description = 'List merge requests created by you';

    /**
     * @param \App\Api\Client                             $client
     * @param \App\Factories\MergeRequestsResourceFactory $factory
     * @return void
     */
    public function handle(Client $client, MergeRequestsResourceFactory $factory)
    {
        $resource = $factory->create($this->options())
            ->query([
                'state' => $this->option('state'),
                'scope' => 'created_by_me',
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