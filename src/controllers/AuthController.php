<?php

namespace project\src\controllers;

use Exception;
use InvalidArgumentException;
use project\Config;
use project\src\entities\APIResponse;
use project\src\entities\validators\SampleDataValidator;
use project\src\daos\AuthDAO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthController
{

    public function __construct()
    {
    }

    public function auth(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        //get config singleton object + phpstorm type hinting

        /** @var Config $config */
        $config = Config::get_instance();
        //get jwt data
        $user = $config->user;
        //get request body data (only with method POST,PUT,PATCH)
        $data = json_decode(json_encode($request->getParsedBody()));
        try {
            // CHeck data user sended to our API
            SampleDataValidator::validate_auth_data($data);
            //execute operation. return must be json_encodable
            $data_to_send = AuthDAO::auth($data->login, $data->password, $config);
            // Using own APIResponse object to standardize our API Response
            $api_response = new APIResponse(0, APIResponse::RESPONSE_SUCCESS, "my message", $data_to_send);
            $response->getBody()->write(json_encode($api_response));
        } catch (InvalidArgumentException $iae) {
            $response->getBody()->write(json_encode(new APIResponse(2, APIResponse::RESPONSE_ERROR, "Les paramètre fournis sont invalide")));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(new APIResponse(1, APIResponse::RESPONSE_ERROR, "Erreur inconnu")));
        }
        return $response;
    }
}
