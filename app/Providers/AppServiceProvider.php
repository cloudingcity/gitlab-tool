<?php

namespace App\Providers;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GuzzleClient::class, function () {
            return new GuzzleClient([
                'base_uri' => config('gitlab.uri'),
                'headers' => ['PRIVATE-TOKEN' => config('gitlab.token')],
                RequestOptions::TIMEOUT => 6,
                RequestOptions::CONNECT_TIMEOUT => 6,
            ]);
        });
    }
}
