<?php

declare(strict_types=1);

namespace App\Api\Standalone;

use App\Api\Resource;

class Version extends Resource
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $endpoint = 'version';
}
