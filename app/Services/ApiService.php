<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class ApiService
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
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
     * @param string $content
     * @return object
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function lintCi(string $content)
    {
        return $this->sendRequest('POST', 'ci/lint', ['form_params' => ['content' => $content]]);
    }

    /**
     * @return object
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchVersion()
    {
        return $this->sendRequest('GET', 'version');
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
