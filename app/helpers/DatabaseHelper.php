<?php

namespace Helpers;

use RedBeanPHP\R as R;

class DatabaseHelper
{
    public static function connect()
    {
        if (R::testConnection()) {
            return;
        }
        $db = require_once __DIR__ . '/../../config/database.php';
        if (!$db['usepassword']) {
            R::setup("mysql:host=" . $db['host'] . ";dbname=" . $db['database'], $db['username']);
        } else {
            R::setup("mysql:host=" . $db['host'] . ";dbname=" . $db['database'], $db['username'], $db['password']);
        }
    }

    public static function reset($table = null)
    {
        if ($table) {
            return R::wipe($table);
        }
        return R::nuke();
    }
}
