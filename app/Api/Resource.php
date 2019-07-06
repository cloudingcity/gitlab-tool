<?php

declare(strict_types=1);

namespace App\Api;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use InvalidArgumentException;

abstract class Resource
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @param array $parameters
     * @return void
     */
    public function __construct(array $parameters = [])
    {
        if (!isset($this->method)) {
            throw new InvalidArgumentException('Method is not set.');
        }

        if (!isset($this->endpoint)) {
            throw new InvalidArgumentException('Endpoint is not set.');
        }

        $this->setupEndpoint($parameters);
    }

    /**
     * @param array $parameters
     * @return void
     */
    protected function setupEndpoint(array $parameters)
    {
        if (empty($parameters)) {
            return;
        }

        $parameters = array_map(function (string $parameter) {
            return (Str::contains($parameter, '/')) ? urlencode($parameter) : $parameter;
        }, $parameters);

        $this->endpoint = Str::replaceArray('?', $parameters, $this->endpoint);
    }

    public function execute(array $params = [])
    {
        $response = $this->getClient()->request(
            $this->method,
            $this->getUri(),
            $this->getOptions($params)
        );

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function getClient(): GuzzleClient
    {
        return Container::getInstance()->make(GuzzleClient::class);
    }

    /**
     * @return string
     */
    protected function getUri(): string
    {
        return 'api/v4/' . $this->endpoint;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function getOptions(array $params): array
    {
        if (empty($params)) {
            return [];
        }

        if ($this->method === 'GET') {
            return ['query' => $params];
        }

        if ($this->method === 'POST') {
            return ['form_params' => $params];
        }

        throw new InvalidArgumentException('Invalid method: ' . $this->method);
    }
}
