<?php

declare(strict_types=1);

namespace App\Helpers;

class Url
{
    /**
     * @param string $url
     * @return string
     */
    public static function parseProject(string $url): string
    {
        [, , , $vendor, $repository] = explode('/', $url);

        return $vendor . '/' . $repository;
    }
}
