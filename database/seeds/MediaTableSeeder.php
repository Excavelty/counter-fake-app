<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Media');

        $upvotes = $faker->numberBetween(0, 3000);
        $downvotes = $faker->numberBetween(0, 2000);
        $result = $upvotes - $downvotes;

        for($i = 1; $i < 100; $i++)
        {
            DB::table('media')->insert(
              [
                  'brand' => $faker->sentence,
                  'description' => $faker->realText(200),
                  'upvotes' => $upvotes,
                  'downvotes' => $downvotes,
                  'result' => $result,
              ]
            );
        }
    }
}
