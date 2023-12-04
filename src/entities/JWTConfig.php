<?php

namespace urca\template\api\entities;

class JWTConfig
{


    private $privateKey;
    private $algorithm;
    private $decoded_var_name;
    private $token_duration;
    private $issuer;

    public function __construct(string $privateKey = "MY_super_Secret_key_ZOMG", string $algorithm = "HS256", string $decoded_var_name = "jwt", int $token_duration = 28800, string $issuer = "localhost")
    {
        $this->privateKey = $privateKey;
        $this->algorithm = $algorithm;
        $this->decoded_var_name = $decoded_var_name;
        $this->token_duration = $token_duration;
        $this->issuer = $issuer;
    }

    /**
     * Get the value of privateKey
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * Set the value of privateKey
     *
     * @return  self
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * Get the value of algorithm
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Set the value of algorithm
     *
     * @return  self
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * Get the value of decoded_var_name
     */
    public function getDecoded_var_name()
    {
        return $this->decoded_var_name;
    }

    /**
     * Set the value of decoded_var_name
     *
     * @return  self
     */
    public function setDecoded_var_name($decoded_var_name)
    {
        $this->decoded_var_name = $decoded_var_name;

        return $this;
    }

    /**
     * Get the value of token_duration
     */
    public function getToken_duration()
    {
        return $this->token_duration;
    }

    /**
     * Set the value of token_duration
     *
     * @return  self
     */
    public function setToken_duration($token_duration)
    {
        $this->token_duration = $token_duration;

        return $this;
    }

    /**
     * Get the value of issuer
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * Set the value of issuer
     *
     * @return  self
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;

        return $this;
    }

}
