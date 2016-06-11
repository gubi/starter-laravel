<?php

namespace Zikkio\Providers;

use Illuminate\Support\ServiceProvider;
use Zikkio\Services\JWT\JWTManagerContract;
use Zikkio\Services\JWT\JWTService;

class JWTServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(JWTManagerContract::class, JWTService::class);
    }
}
