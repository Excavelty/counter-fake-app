<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commentFaker = Faker::create('App\Comment');

        for($i = 1; $i <= 10000; $i++)
        {
            DB::table('comments')->insert(
              [
                  'postId' => $commentFaker->numberBetween(1, 82),
                  'authorName' => 'admin',
                  'content' => $commentFaker->text,
                  'upvotes' => $commentFaker->numberBetween(0, 500),
                  'downvotes' => $commentFaker->numberBetween(0, 250),
                  'created_at' => \Carbon\Carbon::now(),
                  'updated_at' => \Carbon\Carbon::now(),
              ]
            );
        }
    }
}
