<?php

declare(strict_types=1);

namespace App\Services;

class GitlabApiService
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = app('gitlab.client');
    }

    /**
     * @param string $state
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchMergeRequests(string $state) : array
    {
        $response = $this->client->request(
            'GET',
            $this->getEndpoint('merge_requests'),
            ['query' => ['state' => $state]]
        );

        return json_decode((string) $response->getBody());
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getEndpoint(string $path)
    {
        return 'api/v4/' . $path;
    }
}
