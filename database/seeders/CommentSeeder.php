<?php

namespace Database\Seeders;

use Database\Seeder;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public const TABLE = 'comments';
    public static function getData()
    {
        return self::generateData();
    }

    private static function generateData()
    {   
        $faker = Faker::create();
        $data = [];
        for ($i = 0; $i < (15 * 2); $i++) {
            for ($j = 0; $j < random_int(0, 8); $j++) {
                $data[] = [
                    'user_id' => random_int(1, 15),
                    'post_id' => $i + 1,
                    'content' => $faker->text(random_int(30, 100)),
                    'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                ];
            }
        }
        return $data;
    }
}
