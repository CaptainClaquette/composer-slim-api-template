<?php

namespace project\src\entities;

use Firebase\JWT\JWT;

/**
 * Description of JWTHandler
 *
 * @author dere01
 */
class JWTHandler
{

    const USER_TOKEN = 1;
    const SERVER_TOKEN = 2;

    public static function generate_jwt($payload_data, JWTConfig $config, $type = self::USER_TOKEN): string
    {
        $tokenId = base64_encode(random_bytes(128));
        $issuedAt = time();
        $notBefore = $issuedAt;             //Adding 10 seconds
        $expire = $issuedAt + $config->getToken_duration();           // Adding 8 hours
        $serverName = $config->getIssuer();

        $payload = [
            'iat' => $issuedAt, // Issued at: time when the token was generated
            'jti' => $tokenId, // Json Token Id: an unique identifier for the token
            'iss' => $serverName, // Issuer
            'nbf' => $notBefore, // Not before
            'exp' => $expire, // Expire
            'data' => $payload_data
        ];
        return JWT::encode($payload, $config->getPrivateKey(), $config->getAlgorithm());
    }
}
