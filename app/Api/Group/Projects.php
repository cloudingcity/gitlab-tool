<?php

declare(strict_types=1);

namespace App\Api\Group;

use App\Api\Resource;

class Projects extends Resource
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $endpoint = 'groups/?/projects';
}
