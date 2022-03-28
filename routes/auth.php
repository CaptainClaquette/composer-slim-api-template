<?php

use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use project\controllers\AuthController;
use project\middlewares\JSONHeaderMiddleware;
use project\middlewares\JWTCheckerMiddleware;

return function (App $app) {
    $app->group('/auth', function (RouteCollectorProxy $group) {
        $group->post('', [AuthController::class, "auth"])->setName('auth');
    })->add(new JSONHeaderMiddleware());
};
