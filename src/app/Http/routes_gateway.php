<?php

/** @var \Illuminate\Routing\Router $router */

$router->group(['prefix' => 'gateway/',  'middleware' => ['auth:gateway']], function() use($router) {

    $router->group(['prefix' => 'internal/'], function () use ($router) {
        $router->group(['prefix' => 'v1/'], function () use ($router) {

            //Gateway-specific routes...

        });
    });
});