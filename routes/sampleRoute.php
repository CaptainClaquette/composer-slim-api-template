<?php

use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use project\controllers\SampleController;
use project\middlewares\JSONHeaderMiddleware;
use project\middlewares\JWTCheckerMiddleware;

return function (App $app) {
    // Defining sample routes group
    $app->group('/sample', function (RouteCollectorProxy $group) {
        // defining route param "id" (sample/id) and attach to it a controller function
        $group->get('/{id}', [SampleController::class, "get_data"])->setName('get');
        $group->post('', [SampleController::class, "add_data"])->setName('add');
        // Protecting route group through JWT testing and adding header application/json to response with middlewares
    })->add(new JWTCheckerMiddleware($app->getContainer()->get('config')))->add(new JSONHeaderMiddleware());
};
