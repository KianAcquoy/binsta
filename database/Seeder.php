<?php

namespace Database;

require_once __DIR__ . '/../vendor/autoload.php';

use Exception;
use Helpers\DatabaseHelper;
use RedBeanPHP\R as R;

class Seeder
{
    public static function seed($name, $reset = 0)
    {
        DatabaseHelper::connect();
        $seeder = Seeder::getSeeder($name);
        if ($reset) {
            DatabaseHelper::reset($seeder::TABLE);
        }
        $data = $seeder::getData();
        foreach ($data as $row) {
            R::store(R::dispense($seeder::TABLE)->import($row));
        }
    }

    public static function seedAll($reset = 0)
    {
        $seederPath = __DIR__ . '/seeders';
        $seederFiles = glob($seederPath . '/*.php');
        foreach ($seederFiles as $seederFile) {
            $seederName = basename($seederFile, '.php');
            self::seed($seederName, $reset);
        }
    }

    public static function getSeeder($seeder): Seeder
    {
        $seeder = 'Database\Seeders\\' . $seeder;
        if (is_subclass_of($seeder, Seeder::class, true)) {
            return new $seeder();
        }
        throw new Exception("Seeder {$seeder} does not exist.");
    }
}
