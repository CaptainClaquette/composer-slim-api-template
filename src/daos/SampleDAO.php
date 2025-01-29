<?php

namespace urca\template\api\daos;

use hakuryo\db\ConnectionDB;
use urca\template\api\Config;

class SampleDAO
{

    public static function get_data($id)
    {
        $db = ConnectionDB::fromFile(Config::CONFIG_FILE, "db");
        $data = $db->get("SELECT 1 from dual");
        unset($db);
        return $data;
    }

    public static function add_data($data)
    {
        $db = ConnectionDB::fromFile(Config::CONFIG_FILE, "db");
        $modification = $db->modify("INSERT INTO ma_table (libelle,active) VALUES (?,?)", [$data->libelle, $data->active]);
        unset($db);
        return $modification > 0;
    }
}
