<?php

namespace Zikkio\Providers;

use Illuminate\Support\ServiceProvider;
use Zikkio\Services\Exceptions\JSONExceptionsService;
use Zikkio\Services\Exceptions\ExceptionsHandlerContract;

class ExceptionsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExceptionsHandlerContract::class, JSONExceptionsService::class);
    }
}
