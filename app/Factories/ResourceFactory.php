<?php

declare(strict_types=1);

namespace App\Factories;

use App\Api\Resource as ApiResource;

interface ResourceFactory
{
    /**
     * @param array $options
     * @return \App\Api\Resource
     */
    public function create(array $options = []): ApiResource;
}
