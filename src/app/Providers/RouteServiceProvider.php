<?php

namespace Zikkio\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your gateway controller routes.
     *
     * @var string
     */
    protected $gatewayNamespace = 'Zikkio\Http\Controllers\Gateway';

    /**
     * This namespace is applied to your network controller routes.
     *
     * @var string
     */
    protected $networkNamespace = 'Zikkio\Http\Controllers\Network';


    /**
     * Route binding mappings
     * @var array
     */
    protected $routeModelMapping = [
        //Ex. 'users' => UserModel::class
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);

        $this->applyRouteBindings($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapApiRoutes($router);

        //
    }

    /**
     * Define the "api" routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapApiRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->networkNamespace, 'middleware' => 'api',
        ], function ($router) {
            require app_path('Http/routes_network.php');
        });


        $router->group([
            'namespace' => $this->gatewayNamespace, 'middleware' => 'api',
        ], function ($router) {
            require app_path('Http/routes_gateway.php');
        });
    }

    protected function applyRouteBindings(Router $router)
    {
        foreach($this->routeModelMapping as $routeParameter => $model) {
            $router->model($routeParameter, $model);
        }
    }
}
