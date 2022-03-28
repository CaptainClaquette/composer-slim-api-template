<?php

namespace project\middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

/**
 * Description of JSONHeaderMiddleware
 *
 * @author Hakuryo
 */
class JSONHeaderMiddleware {

    public $config;

    public function __construct() {
    }

    /**
     * Example middleware invokable class
     *
     * @param  ServerRequestInterface  $request PSR-7 request
     * @param  RequestHandlerInterface $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): Response {
        $response = $handler->handle($request);
        return $response->withHeader("Content-Type", "application/json");
    }

}
