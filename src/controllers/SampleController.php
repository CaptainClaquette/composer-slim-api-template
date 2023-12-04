<?php

namespace urca\template\api\controllers;

use Exception;
use InvalidArgumentException;
use urca\template\api\daos\SampleDAO;
use urca\template\api\entities\APIResponse;
use urca\template\api\entities\validators\SampleDataValidator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use urca\template\api\Config;

class SampleController
{

    public function __construct()
    {
    }

    public function get_member(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        //get config singleton object
        $config = Config::get_instance();

        //get request body data (only with method POST,PUT,PATCH)
        //$data = json_decode(json_encode($request->getParsedBody()));

        //get Query params. You should test for every params you need if it exist.
        //$data $request->getQueryParams();

        //get route param "id" or null if not provided only with method (DELETE,GET).
        $id_route_params = $request->getAttribute("id", null);
        try {
            //execute operation. return muste be json_encodable
            $data_to_send = SampleDAO::get_data($id_route_params);
            $api_response = new APIResponse(0, APIResponse::RESPONSE_SUCCESS, "my message", $data_to_send);
            $response->getBody()->write(json_encode($api_response));
        } catch (InvalidArgumentException $iae) {
            $response->getBody()->write(json_encode(new APIResponse(2, APIResponse::RESPONSE_ERROR, "Les paramètre fournis sont invalide")));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(new APIResponse(1, APIResponse::RESPONSE_ERROR, "Erreur inconnu")));
        }
        return $response;
    }

    public function add_data(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        //get config singleton object
        $config = Config::get_instance();
        //get request body data (only with method POST,PUT,PATCH)
        $data = json_decode(json_encode($request->getParsedBody()));
        try {
            SampleDataValidator::validate_sample_operation_data($data);
            //execute operation. return muste be json_encodable
            $api_response = new APIResponse(0, APIResponse::RESPONSE_SUCCESS);
            if (SampleDAO::add_data($data)) {
                $api_response->setMessage("Ajout reussi");
            } else {
                $api_response->setCode(3)->setMessage("Problème lors de l'ajout");
            }
            $response->getBody()->write(json_encode($api_response));
        } catch (InvalidArgumentException $iae) {
            $response->getBody()->write(json_encode(new APIResponse(2, APIResponse::RESPONSE_ERROR, "Les paramètre fournis sont invalide")));
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(new APIResponse(1, APIResponse::RESPONSE_ERROR, "Erreur inconnu")));
        }
        return $response;
    }
}
