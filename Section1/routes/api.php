<?php

use Dingo\Api\Routing\Router;

/** @var Dingo\Api\Routing\Router $router */
$router = app(Router::class);

$router->version('v1', function (Router $router) {
    $router->group(['namespace' => 'App\Http\Controllers'], function ($router) {
        // System status
        $router->group(['prefix' => 'status'], function (Router $router) {
            $router->get('ping', 'ServerController@ping');
            $router->get('version', 'ServerController@version');
        });
    });
});