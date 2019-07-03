<?php

declare(strict_types=1);

namespace App\Apis\Standalone;

use App\Apis\Resource;

class MergeRequests extends Resource
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $endpoint = 'merge_requests';
}
