<?php

namespace Zikkio\Providers;

use Illuminate\Support\ServiceProvider;
use Zikkio\Services\Uuid\Uuid4GeneratorService;
use Zikkio\Services\Uuid\UuidGeneratorContract;

class UuidGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UuidGeneratorContract::class, Uuid4GeneratorService::class);
    }
}
