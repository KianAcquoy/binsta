<?php

namespace Database\Seeders;

use Database\Seeder;
use Faker\Factory as Faker;
use FilesystemIterator;

class PostSeeder extends Seeder
{
    public const TABLE = 'posts';
    public static function getData()
    {
        return self::generateData();
    }
    
    private static function getRandomSnippet()
    {
        $files = glob( __DIR__ . '../../demo/snippets/*.*');
        return $files[array_rand($files)];
    }

    private static function generateData()
    {   
        $faker = Faker::create();
        $data = [];
        for ($userid = 1; $userid <= 15; $userid++) {
            for ($i = 0; $i < 2; $i++) {
                $randomsnippet = PostSeeder::getRandomSnippet();
                $data[] = [
                    'user_id' => $userid,
                    'content' => file_get_contents($randomsnippet),
                    'caption' => $faker->text(random_int(50, 200)),
                    'language' => pathinfo($randomsnippet)['extension'],
                    'created_at' => $faker->dateTimeBetween('-3 year', 'now')->format('Y-m-d H:i:s'),
                ];
            }
        }
        return $data;
    }
}
