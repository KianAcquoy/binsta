namespace Database\Seeders;

use Database\Seeder;
use Faker\Factory as Faker;

class LikeSeeder extends Seeder
{
    public const TABLE = 'likes';
    public static function getData()
    {
        return self::generateData();
    }

    private static function generateData()
    {   
        $faker = Faker::create();
        $data = [];
        for ($i = 0; $i < (15 * 2); $i++) {
            for ($j = 0; $j < random_int(0, 15); $j++) {
                $data[] = [
                    'post_id' => $i + 1,
                    'user_id' => random_int(1, 15),
                    'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                ];
            }
        }
        return $data;
    }
}
