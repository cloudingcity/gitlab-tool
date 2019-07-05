<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use App\Api\Group\Search as GroupSearch;
use App\Api\Project\Search as ProjectSearch;
use App\Api\Standalone\Search;
use App\Factories\SearchResourceFactory;
use Tests\TestCase;

class SearchResourceFactoryTest extends TestCase
{
    public function testCreateSearch()
    {
        $factory = new SearchResourceFactory();
        $resource = $factory->create();

        $this->assertInstanceOf(Search::class, $resource);
    }

    public function testCreateProjectSearch()
    {
        $factory = new SearchResourceFactory();
        $resource = $factory->create(['project' => 'foo']);

        $this->assertInstanceOf(ProjectSearch::class, $resource);
    }

    public function testCreateGroupSearch()
    {
        $factory = new SearchResourceFactory();
        $resource = $factory->create(['group' => 'foo']);

        $this->assertInstanceOf(GroupSearch::class, $resource);
    }
}
