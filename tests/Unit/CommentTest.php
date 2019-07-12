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
          $response = $this->prepareTestForStoreMethod($faker->lexify($content),
            $faker->numberBetween(1, 100));

          $response->assertStatus(200)->assertJson([
              'success' => 'Poprawnie dodano komentarz',
          ]);
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
