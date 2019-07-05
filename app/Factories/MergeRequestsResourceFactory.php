<?php

declare(strict_types=1);

namespace App\Factories;

use App\Api\Group\MergeRequests as GroupMergeRequests;
use App\Api\Project\MergeRequests as ProjectMergeRequests;
use App\Api\Resource as ApiResource;
use App\Api\Standalone\MergeRequests;

class MergeRequestsResourceFactory implements ResourceFactory
{
    /**
     * @param array $options
     * @return \App\Api\Resource
     */
    public function create(array $options = []): ApiResource
    {
        if (isset($options['project'])) {
            return new ProjectMergeRequests($options['project']);
        }

        if (isset($options['group'])) {
            return new GroupMergeRequests($options['group']);
        }

        return new MergeRequests();
    }
}
