<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use App\Api\Group\MergeRequests as GroupMergeRequests;
use App\Api\Project\MergeRequests as ProjectMergeRequests;
use App\Api\Standalone\MergeRequests;
use App\Factories\MergeRequestsResourceFactory;
use Tests\TestCase;

class MergeRequestsResourceFactoryTest extends TestCase
{
    public function testCreateMergeRequests()
    {
        $factory = new MergeRequestsResourceFactory();
        $resource = $factory->create();

        $this->assertInstanceOf(MergeRequests::class, $resource);
    }

    public function testCreateProjectMergeRequests()
    {
        $factory = new MergeRequestsResourceFactory();
        $resource = $factory->create(['project' => 'foo']);

        $this->assertInstanceOf(ProjectMergeRequests::class, $resource);
    }

    public function testCreateGroupMergeRequests()
    {
        $factory = new MergeRequestsResourceFactory();
        $resource = $factory->create(['group' => 'foo']);

        $this->assertInstanceOf(GroupMergeRequests::class, $resource);
    }
}
