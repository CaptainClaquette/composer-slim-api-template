<?php

namespace project;

use DI\Container;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use project\classes\JWTConfig;
use project\controllers\SampleController;


class Config
{
    /** @var string ini file to configure application */
    const CONFIG_FILE = __DIR__ . "/config/config.ini";
    /** @var JWTConfig Object to store and access the jwt config */
    public $jwt;
    /** @var string base path of the slim API */
    public $app_base_path = "";
    /** @var bool flag to indicate if application is in production */
    public $production = false;
    /** @var Logger Monolog logger to have only one instance through the application */
    private $loggers;

    public function __construct()
    {

        $conf = parse_ini_file(self::CONFIG_FILE, true);
        $this->jwt = new JWTConfig();
        $this->jwt->setPrivateKey($conf['jwt']['key'])
            ->setAlgorithm($conf['jwt']['algorithm'])
            ->setDecoded_var_name($conf['jwt']['decoded_var_name'])
            ->setToken_duration($conf['jwt']['token_duration'])
            ->setIssuer($conf['jwt']['issuer']);
        $this->app_base_path = $conf['app']['base_path'];
    }


}
