# SLIM API TEMPLATE

This project is a SLIM API template bundled with the following composer package :

- slim/slim: 4.9+,
- firebase/php-jwt: 5.5+,
- monolog/monolog: 2.3+,
- hakuryo/database-client": 1.3+,
- php-di/php-di": 6.3+,
- slim/psr7": 1.5+,

## Requirement

### Mandatory

- PHP 7.4+
- PHP module :
    - php-json
    - php-pdo
    - php-mysql

### Optional

- PHP module :
    - oci8 [How to install OCI8](https://github.com/CaptainClaquette/composer-database-client/blob/main/How%20to%20install%20PHP%2C%20Instantclient%20and%20PHP_PDO_OCI.md)
    - pdo_oci [How to install PDO_OCI](https://github.com/CaptainClaquette/composer-database-client/blob/main/How%20to%20install%20PHP%2C%20Instantclient%20and%20PHP_PDO_OCI.md#php_pdo_oci)

## Install

`composer create-project hakuryo/slim-api-template [local_path_of_your_project]`

## Configuration

This template is initialized by the Config class. The class load an INI file to configure the application.
> :warning:  
> The default location is `__DIR__ . "/config/config.ini"`. Please take note that's **NOT A GOOD** location for production. You **SHOULD** place the config file outside your web root.
> > If you can not place the INI file outside your web root please consider using ACL like htaccess to prevent the reading of the file.

Below a sample config file.

```INI
# Global APP config sample
[app]
bath_path=""

# JWT token config sample
[jwt]
key = My_super_private_key; private Key for JWT generation
algorithm = HS256; Algorithm for JWT signature generation
decoded_var_name = decoded_jwt; decoded JWT is stored in $_REQUEST[decoded_var_name]
token_duration = 28800
issuer = my-server.example.com

# hakuryo/ldap-client config sample
[ldap]
HOST = "ldap.example.com"
USER = "uid=my_login,dc=example,dc=com"
DN = "dc=example,dc=com"
PWD = "ldap_pwd"

# hakuryo/database-client config sample for mysql
[db]
HOST = "db.example.com";
DB = "my_db";
USER = "my_user";
PWD = "my_user_pwd"
PORT = 3306
DRIVER = "mysql"

# hakuryo/database-client config sample for oracle
[oci]
HOST = "oracle.example.com";
DB = "my_oracle_db";
USER = "my_user";
PWD = "my_owd";
PORT = 12345
DRIVER = "oci"
```
