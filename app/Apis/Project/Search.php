<?php

declare(strict_types=1);

namespace App\Apis\Project;

use App\Apis\Resource;

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
