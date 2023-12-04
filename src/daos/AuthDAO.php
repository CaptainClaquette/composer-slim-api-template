<?php

namespace urca\template\api\daos;

use urca\template\api\entities\JWTHandler;
use urca\template\api\Config;

class AuthDAO
{

    public static function auth(string $login, string $password, Config $config)
    {
          // Check for user credential
//        $db = ConnectionDB::from_file(Config::CONFIG_FILE, "db");
//        $data = $db->get("SELECT username,mail,role_id from user where login = ? and user_password = ?", [$login, $password]);
//        unset($db);
//        if (!property_exists($data, "username")) {
//            throw new Exception("Invalid credential", 3);
//        }
        // creating sample user data to store in JWT
        $data = new \stdClass();
        $data->displayname = "BOB MORAN";
        $data->mail = "bob.moran@supermail.com";
        $data->role = "Adventurer";
        return JWTHandler::generate_jwt($data, $config->jwt);
    }
}
