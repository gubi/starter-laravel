<?php
/** @var \Illuminate\Routing\Router $router */

$router->group(['prefix' => 'internal/'], function() use($router) {

    $router->group(['prefix' => 'gateway/', 'middleware' => ['auth:gateway']], function () use ($router) {
        $router->group(['prefix' => 'v1/', 'middleware' => ['auth:gateway']], function () use ($router) {

            //Gateway-specific routes...

        });
    });

    $router->group(['prefix' => 'network/', 'middleware' => ['auth:service']], function () use ($router) {
        $router->group(['prefix' => 'v1/', 'middleware' => ['auth:gateway']], function () use ($router) {

            //Network-specific routes...

        });
    });

});


