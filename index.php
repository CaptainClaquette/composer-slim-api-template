<?php

use project\Config;
use Slim\Factory\AppFactory;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT,PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');

require __DIR__ . '/vendor/autoload.php';

$config = Config::get_instance();
// Instantiate an APP
$app = AppFactory::create();
// Set APP base path AKA the directory from Document ROOT where the APP is located
$app->setBasePath($config->app_base_path);
// Add body parsing middleware. It's needed to use slim getParsedBody Function
$app->addBodyParsingMiddleware();

//allow options method for all route. Needed to use API within webbrowser.
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

// Register all our routes.
foreach (glob("./src/routes/*.php") as $filename) {
    (require $filename)($app);
}

/*
############# ERROR HANDLING

Uncomment below section to make handle error properly.
You must change the logic inside the $customErrorHandler function to fit your needs.
SLIM throw php error in the face of your user by default.

Its a good thing in developpement but a TERRIBLE SECURITY BREACH in production !!!!!!

*/

//$customErrorHandler = function (RequestInterface $request, Throwable $exception, bool $displayErrorDetails = true, bool $logErrors, bool $logErrorDetails, ?LoggerInterface $logger = null) use ($app) {
//
//    $payload = new APIResponse(0, APIResponse::RESPONSE_ERROR);
//    if ($exception instanceof HttpMethodNotAllowedException) {
//        $payload->setMessage('Not found');
//    }
//    $response = $app->getResponseFactory()->createResponse();
//    $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE));
//    return $response->withStatus(200)->withHeader("Content-Type", "application/json");
//};
//$errorMiddleware = $app->addErrorMiddleware(true, false, false);
//$errorMiddleware->setDefaultErrorHandler($customErrorHandler);
$app->run();
