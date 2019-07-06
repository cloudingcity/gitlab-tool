<?php

declare(strict_types=1);

namespace App\Factories;

use App\Api\Group\Search as GroupSearch;
use App\Api\Project\Search as ProjectSearch;
use App\Api\Resource as ApiResource;
use App\Api\Standalone\Search;

class SearchResourceFactory implements ResourceFactory
{
    /**
     * @param array $options
     * @return \App\Api\Resource
     */
    public function create(array $options = []): ApiResource
    {
        if (isset($options['project'])) {
            return new ProjectSearch([$options['project']]);
        }

        if (isset($options['group'])) {
            return new GroupSearch([$options['group']]);
        }

        return new Search();
    }
}
