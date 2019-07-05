<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use App\Apis\Group\Search as GroupSearch;
use App\Apis\Project\Search as ProjectSearch;
use App\Apis\Standalone\Search;
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
