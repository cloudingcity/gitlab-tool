<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class GitlabApiService
{
    /**
     * @var string
     */
    const MERGE_REQUEST_STATE_OPENED = 'opened';

    /**
     * @var string
     */
    const MERGE_REQUEST_STATE_CLOSED = 'closed';

    /**
     * @var string
     */
    const MERGE_REQUEST_STATE_LOCKED = 'locked';

    /**
     * @var string
     */
    const MERGE_REQUEST_STATE_MERGED = 'merged';

    /*
     * @var \Guzzle\client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('gitlab.uri'),
            'headers' => ['PRIVATE-TOKEN' => config('gitlab.token')]
        ]);
    }

    /**
     * Fetch merge requests.
     *
     * @param string $state
     * @return array
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchMergeRequests(string $state) : array
    {
        $response = $this->client->request(
            'GET',
            'merge_requests',
            ['query' => ['author_id' => config('gitlab.author_id'), 'state' => $state]]
        );

        return json_decode((string) $response->getBody());
    }
}
