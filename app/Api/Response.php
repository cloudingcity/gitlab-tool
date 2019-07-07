<?php

declare(strict_types=1);

namespace App\Api;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response
{
    /**
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;

    /**
     * @param \GuzzleHttp\Psr7\Response $response
     */
    public function __construct(GuzzleResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return json_decode($this->response->getBody()->getContents(), true);
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return (int) $this->response->getHeaderLine('X-Total');
    }

    /**
     * @return int
     */
    public function getTotalPage(): int
    {
        return (int) $this->response->getHeaderLine('X-Total-Pages');
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return (int) $this->response->getHeaderLine('X-Per-Page');
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return (int) $this->response->getHeaderLine('X-Page');
    }

    /**
     * @return int
     */
    public function getNextPage(): int
    {
        return (int) $this->response->getHeaderLine('X-Next-Page');
    }

    /**
     * @return int
     */
    public function getPrevPage(): int
    {
        return (int) $this->response->getHeaderLine('X-Prev-Page');
    }
}
