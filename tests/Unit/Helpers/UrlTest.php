<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use App\Helpers\Url;
use Tests\TestCase;

class UrlTest extends TestCase
{
    public function testParseProject()
    {
        $url = 'https://gitlab.com/foo/bar/merge_requests/123';

        $this->assertSame('foo/bar', Url::parseProject($url));
    }
}
