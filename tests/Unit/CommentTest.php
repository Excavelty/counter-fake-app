<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use App\Comment;
use App\User;

class CommentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testIfStoreMethodReturnsSuccessMessageAsValidJsonGivenValidData()
    {
          $faker = Faker::create('App\Comment');
          $content = str_repeat('?', 120);
          $response = $this->prepareTestForStoreMethod($faker->numberBetween(1, 80),
            $faker->lexify($content));

          $response->assertStatus(200)->assertJson([
              'success' => 'Poprawnie dodano komentarz',
          ]);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooShortContent()
    {
        $faker = Faker::create('App\Comment');
        $response = $this->prepareTestForStoreMethod($faker->numberBetween(1, 80), $faker->text(13));

        $response->assertStatus(422);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooLongContent()
    {
        $faker = Faker::create('App\Comment');
        $content = str_repeat('?', 301);
        $response = $this->prepareTestForStoreMethod($faker->numberBetween(1, 80),
          $faker->lexify($content));

        $response->assertStatus(422);
    }

    private function prepareTestForStoreMethod($postId, $content)
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('POST', "/add-comment" . "/" . $postId,
        [
            'content' => $content,
        ]
        );

        return $response;
    }
}
