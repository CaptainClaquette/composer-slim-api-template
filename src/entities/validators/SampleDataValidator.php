<?php

namespace project\src\entities\validators;

use InvalidArgumentException;

class SampleDataValidator
{

    public static function validate_sample_operation_data($data)
    {

        if (!property_exists($data, "id") || !is_int($data->id)) {
            throw new InvalidArgumentException("id is not a int or does not exist", 2);
        }
        if (!property_exists($data, "structure")) {
            throw new InvalidArgumentException("structure variable is mandatory", 2);
        }
        if (!property_exists($data->structure, "id")) {
            throw new InvalidArgumentException("structure id is not a int or does not exist", 2);
        }
        if (!property_exists($data->structure, "libelle") || !is_string($data->structure->libelle)) {
            throw new InvalidArgumentException("libelle is not a string or does not exist", 2);
        }
        if (!property_exists($data->structure, "active") || !is_bool($data->structure->active)) {
            throw new InvalidArgumentException("structure.active is not a boolean or does not exist", 2);
        }
        //...
    }

    public static function validate_auth_data($data)
    {

        if (!property_exists($data, "login") || !is_string($data->login)) {
            throw new InvalidArgumentException("login is not a string or does not exist", 2);
        }
        if (!property_exists($data, "password") || !is_string($data->password)) {
            throw new InvalidArgumentException("password is not a string or does not exist", 2);
        }
    }
}
