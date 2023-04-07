<?php

namespace project;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use project\src\entities\JWTConfig;
use Exception;

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
    private $logger;
    public $user;

    private static $instance = null;

    public static function get_instance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new self();
            $conf = parse_ini_file(self::CONFIG_FILE, true);
            self::$instance->jwt = new JWTConfig();
            self::$instance->jwt->setPrivateKey($conf['jwt']['key'])
                ->setAlgorithm($conf['jwt']['algorithm'])
                ->setDecoded_var_name($conf['jwt']['decoded_var_name'])
                ->setToken_duration($conf['jwt']['token_duration']);
            self::initLogger($conf['logger']);
        }
        return self::$instance;
    }

    private static function initLogger($loggerConf)
    {
        self::$instance->logger = new Logger($loggerConf['logger_name']);
        $formatter = new LineFormatter($loggerConf['logger_line_format'] . "\n", "Y-m-d H:i:s");
        $handler = null;
        switch ($loggerConf['logger_class']) {
            case "ErrorLogHandler":
                $handler = new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, self::getLoggerLevel($loggerConf['logger_level']));
                break;
            case "RotatingFileHandler":
                $handler = new RotatingFileHandler($loggerConf['log_file_path'], 0, self::getLoggerLevel($loggerConf['logger_level']), true, 0644);
                $handler->setFilenameFormat($loggerConf['log_file_name_format'], $loggerConf['log_file_name_date_format']);
                break;
            case "StreamHandler":
                $handler = new StreamHandler($loggerConf['log_file_path'], self::getLoggerLevel($loggerConf['logger_level']), true, 0644);
                break;
        }
        $handler->setFormatter($formatter);
        self::$instance->logger->pushHandler($handler);
    }

    public function getLogger(): Logger
    {
        return self::$instance->logger;
    }

    private static function getLoggerLevel($level)
    {
        switch (strtolower($level)) {
            case 'debug':
                return Level::Debug;
            case 'info':
                return Level::Info;
            case 'notice':
                return Level::Notice;
            case 'warning':
                return Level::Warning;
            case 'error':
                return Level::Error;
            case 'critical':
                return Level::Critical;
            case 'emergency':
                return Level::Emergency;
        }
        return Level::Error;
    }


    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    private function __construct()
    {
    }

    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * prevent from being unserialized (which would create a second instance of it)
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }


}
