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
    public function fetchMergeRequests(string $state): array
    {
        return $this->sendRequest('GET', 'merge_requests', ['query' => ['state' => $state]]);
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array  $options
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequest(string $method, string $endpoint, array $options = [])
    {
        $response = $this->client->request($method, $this->getApiEndpoint($endpoint), $options);

        return json_decode((string) $response->getBody());
    }

    /**
     * @param string $endpoint
     * @return string
     */
    protected function getApiEndpoint(string $endpoint)
    {
        return 'api/v4/' . $endpoint;
    }
}
