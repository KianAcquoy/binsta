<?php

namespace Database\Seeders;

use Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public const TABLE = 'users';
    public static function getData()
    {
        return self::generateData();
    }

    private static function generateData()
    {   
        $faker = Faker::create();
        $data = [];
        $options = ['male', 'female'];
        for ($i = 0; $i < 15; $i++) {
            $picurl = "https://xsgames.co/randomusers/assets/avatars/" . $options[array_rand($options)] . "/" . random_int(0, 78) . ".jpg";
            $data[] = [
                'username' => $faker->username,
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'biography' => $faker->text,
                'avatar' => $picurl,
            ];
        }
        return $data;
    }
}
