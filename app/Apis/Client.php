<?php

declare(strict_types=1);

namespace App\Apis;

use App\Exceptions\ApiException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param \GuzzleHttp\Client $client
     * @return void
     */
    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param \App\Apis\Resource $resource
     * @return mixed
     *
     * @throws \App\Exceptions\ApiException
     */
    public function request(Resource $resource)
    {
        try {
            return $this->sendRequest($resource);
        } catch (GuzzleException $exception) {
            throw new ApiException($exception->getMessage());
        }
    }

    /**
     * @param \App\Apis\Resource $resource
     * @return mixed
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequest(Resource $resource)
    {
        $items = $resource->all();

        $response = $this->client->request(
            $items['method'],
            $this->getUri($items['endpoint']),
            $this->getOptions($items)
        );

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $endpoint
     * @return string
     */
    protected function getUri(string $endpoint): string
    {
        return 'api/v4/' . $endpoint;
    }

    /**
     * @param array $items
     * @return array
     */
    protected function getOptions(array $items): array
    {
        $options = [];

        if (!empty($items['query'])) {
            $options['query'] = $items['query'];
        }

        if (!empty($items['body'])) {
            $options['form_params'] = $items['body'];
        }

        return $options;
    }
}
