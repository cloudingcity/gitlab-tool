<?php

declare(strict_types=1);

namespace App\Api\Project;

use App\Api\Resource;

class MergeRequests extends Resource
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $endpoint = 'projects/?/merge_requests';
}
