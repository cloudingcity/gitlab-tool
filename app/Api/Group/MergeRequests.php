<?php

declare(strict_types=1);

namespace App\Api\Group;

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
    protected $endpoint = 'groups/?/merge_requests';
}
