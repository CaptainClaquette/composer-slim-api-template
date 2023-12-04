<?php

use urca\template\api\controllers\AuthController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    // Define a group of route
    $app->group('/auth', function (RouteCollectorProxy $group) {
        //define a endpoint witch respond to POST resquest
        $group->post('', [AuthController::class, "auth"])->setName('auth');
    });
};
