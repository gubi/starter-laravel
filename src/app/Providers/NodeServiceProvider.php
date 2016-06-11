<?php

namespace Zikkio\Providers;

use Illuminate\Support\ServiceProvider;
use Zikkio\Services\Core\Nodes\NodeService;
use Zikkio\Services\Core\Nodes\NodeServiceContract;

class NodeServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NodeServiceContract::class, NodeService::class);
    }
}
