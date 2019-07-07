<?php

namespace App\Commands;

use App\Api\Group\Projects as GroupProjects;
use App\Api\Project\RepositoryRaw;
use GuzzleHttp\Exception\ClientException;
use LaravelZero\Framework\Commands\Command;

class CheckPhpComposerCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'check:php:composer
                            {group : The group to check in}
                            {package : The compsoer package to check in}';

    /**
     * @var string
     */
    protected $description = 'Check composer.json which project required';

    /**
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $projects = $this->getProjects();
        $results = $this->getResult($projects);

        $this->table(['Project', 'Version', 'Branch', 'Url'], $results, 'box');
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getProjects(): array
    {
        $generator = (new GroupProjects([$this->argument('group')]))->getGenerator([
            'simple' => true,
            'with_shared' => false,
        ]);

        $projects = [];

        foreach ($generator as $response) {
            foreach ($response->getData() as $data) {
                $projects[] = [
                    'id' => $data['id'],
                    'name' => $data['path_with_namespace'],
                    'default_branch' => $data['default_branch'],
                    'web_url' => $data['web_url'],
                ];
            }
        }

        return $projects;
    }

    /**
     * @param array $projects
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getResult(array $projects): array
    {
        $results = [];

        foreach ($projects as $project) {
            try {
                $content = (new RepositoryRaw([$project['id'], 'composer.json']))->execute([
                    'ref' => $project['default_branch'],
                ])->getData();

                if (isset($content['require'][$this->argument('search')])) {
                    $results[] = [
                        'name' => $project['name'],
                        'version' => $content['require'][$this->argument('search')],
                        'default_branch' => $project['default_branch'],
                        'web_url' => $project['web_url'],
                    ];
                }
            } catch (ClientException $exception) {
                continue;
            }
        }

        return $results;
    }
}
