<?php

declare(strict_types=1);

namespace App\Api\Standalone;

use App\Api\Resource;

class Lint extends Resource
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var string
     */
    protected $endpoint = 'ci/lint';
}
