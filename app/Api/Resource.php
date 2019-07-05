<?php

declare(strict_types=1);

namespace App\Api;

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
     * @var array
     */
    protected $query = [];

    /**
     * @var array
     */
    protected $body = [];

    /**
     * @param string[] $parameters
     */
    public function __construct(string ...$parameters)
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
     */
    protected function setupEndpoint(array $parameters)
    {
        if (empty($parameters)) {
            return;
        }

        $parameters = array_map(function (string $parameter) {
            return urlencode($parameter);
        }, $parameters);

        $this->endpoint = Str::replaceArray('?', $parameters, $this->endpoint);
    }

    /**
     * @param array $query
     * @return $this
     */
    public function query(array $query): self
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param array $body
     * @return $this
     */
    public function body(array $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return [
            'method' => $this->method,
            'endpoint' => $this->endpoint,
            'query' => $this->query,
            'body' => $this->body,
        ];
    }
}
