<?php
/** @var \Illuminate\Routing\Router $router */

$router->group(['prefix' => 'network/', 'middleware' => ['auth:service']], function() use($router) {

    $router->group(['prefix' => 'internal/'], function () use ($router) {
        $router->group(['prefix' => 'v1/'], function () use ($router) {

            //Network-specific routes...

        });
    });

});