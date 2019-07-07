<?php

namespace App\Commands;

use App\Api\Response;
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
     * @param \App\Factories\MergeRequestsResourceFactory $factory
     * @return void
     */
    public function handle(MergeRequestsResourceFactory $factory)
    {
        $response = $factory->create($this->options())
            ->execute([
                'state' => $this->option('state'),
                'scope' => 'created_by_me',
                'order_by' => 'updated_at',
                'sort' => 'asc',
            ]);

        $this->render($response);
    }

    /**
     * @param \App\Api\Response $response
     * @return void
     */
    protected function render(Response $response)
    {
        $this->output->listing([
            'Page: ' . $response->getPage() . '/' . $response->getTotalPage(),
            'Per Page: ' . $response->getPerPage(),
            'Total: ' . $response->getTotal(),
        ]);

        foreach ($response->getData() as $item) {
            $updatedAt = Carbon::createFromTimeString($item['updated_at'])->toDateTimeString();

            $this->table(
                ['Project', Url::parseProject($item['web_url'])],
                [
                    ['Branch', $item['source_branch']],
                    ['Assignee', $item['assignee']['name'] ?? null],
                    ['Updated At', $updatedAt],
                    ['Url', $item['web_url']],
                ],
                'box'
            );
        }
    }
}
