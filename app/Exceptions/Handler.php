<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * @var array
     */
    protected $dontReport = [];

    /**
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($exception instanceof ClientException) {
            $contents = $exception->getResponse()->getBody()->getContents();
            $message = json_decode($contents)->message;

            exit("\033[01;31m $message \033[0m". PHP_EOL);
        }

        parent::report($exception);
    }
}
