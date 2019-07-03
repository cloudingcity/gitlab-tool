<?php

declare(strict_types=1);

namespace App\Apis\Standalone;

use App\Apis\Resource;

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
