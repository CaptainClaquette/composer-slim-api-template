<?php

namespace urca\template\api\middlewares;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use UnexpectedValueException;
use urca\template\api\Config;

/**
 * Description of JWTCheckerMiddleware
 *
 * @author Hakuryo
 */
class JWTCheckerMiddleware
{


    public function __construct()
    {
    }

    /**
     * Example middleware invokable class
     *
     * @param Request $request PSR-7 request
     * @param RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $config = Config::get_instance();
        $authorization_headers = $request->getHeader('Authorization', null);
        $jwt = null;
        $response = new Response();
        if ($authorization_headers != null && 0 === stripos($authorization_headers[0], 'Bearer ')) {
            $jwt = substr($authorization_headers[0], 7);
            try {
                $jwt = JWT::decode($jwt, new Key($config->jwt->getPrivateKey(), $config->jwt->getAlgorithm()));
                $config->user = $jwt->data;
                return $handler->handle($request);
            } catch (SignatureInvalidException $e) {
                $response->getBody()->write(json_encode(["error" => "Token", "message" => "Your token is corrupted"]));
            } catch (BeforeValidException $e) {
                $response->getBody()->write(json_encode(["error" => "Token", "message" => $e->getMessage()]));
            } catch (ExpiredException $e) {
                $response->getBody()->write(json_encode(["error" => "Token", "message" => 'Your token has expired. Please authenticate to get a new token']));
            } catch (UnexpectedValueException $e) {
                $response->getBody()->write(json_encode(["error" => "Token", "message" => 'Your token is invalid']));
            }
        } else {
            $response->getBody()->write(json_encode(["error" => "Token", "message" => 'You must provide an authorization token']));
        }
        return $response->withHeader("Content-Type", "application/json")->withStatus(403);
    }
}
