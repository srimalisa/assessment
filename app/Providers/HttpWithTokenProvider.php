<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HttpWithTokenProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('http_client', function ($app) {
            if(Auth::check()) {
                $token = Auth::user()->api_token;
                return Http::withToken($token);
            }
            return new \Illuminate\Http\Client\Factory();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
