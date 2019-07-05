<?php

declare(strict_types=1);

namespace App\Factories;

use App\Apis\Resource as ApiResource;

interface ResourceFactory
{
    /**
     * @param array $options
     * @return \App\Apis\Resource
     */
    public function create(array $options = []): ApiResource;
}
