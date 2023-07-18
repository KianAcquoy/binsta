<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Database\Seeder;

parse_str(implode('&', array_slice($argv, 1)), $_GET);

$reset = 0;
if (isset($_GET['-r'])) {
    $reset = 1;
}

if (!isset($_GET['-s']) || strlen($_GET['-s']) == 0) {
    echo "Please specify a seeder to run. (Tip: use 'all' to seed all)\n";
    exit(1);
}

if ($_GET['-s'] == 'all') {
    echo "Seeding all seeders...\n";
    Seeder::seedAll($reset);
    echo "Done!\n";
} else {
    echo "Seeding {$_GET['-s']}...\n";
    Seeder::seed($_GET['-s'], $reset);
    echo "Done!\n";
}
