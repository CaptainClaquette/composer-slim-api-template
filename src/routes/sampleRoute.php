<?php

use urca\template\api\controllers\SampleController;
use urca\template\api\middlewares\JWTCheckerMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Defining sample routes group
    $app->group('/sample', function (RouteCollectorProxy $group) {
        // defining route param "id" (sample/id) and attach to it a controller function
        $group->get('/{id}', [SampleController::class, "get_data"])->setName('get');
        $group->post('', [SampleController::class, "add_data"])->setName('add');
        // Protecting route group through JWT testing and adding header application/json to response with middlewares
    })->add(new JWTCheckerMiddleware());
};
