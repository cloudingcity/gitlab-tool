<?php

declare(strict_types=1);

namespace App\Factories;

use App\Apis\Group\Search as GroupSearch;
use App\Apis\Project\Search as ProjectSearch;
use App\Apis\Resource as ApiResource;
use App\Apis\Standalone\Search;

class SearchResourceFactory implements ResourceFactory
{
    /**
     * @param array $options
     * @return \App\Apis\Resource
     */
    public function create(array $options = []): ApiResource
    {
        if (isset($options['project'])) {
            return new ProjectSearch($options['project']);
        }

        if (isset($options['group'])) {
            return new GroupSearch($options['group']);
        }

        return new Search();
    }
}
