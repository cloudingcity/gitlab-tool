<?php

declare(strict_types=1);

namespace App\Api\Project;

use App\Api\Resource;

class Search extends Resource
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $endpoint = 'projects/?/search';
}
