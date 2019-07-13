<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use App\User;
use App\Post;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testIfStoreMethodReturnsSuccessMessageAsValidJsonGivenValidData()
    {
        $faker = Faker::create('App\Post');//maybe do smth with this to be sure that it passes test
        $response = $this->prepareTestForStoreMethod($faker->sentence, $faker->text,
        $faker->numberBetween(1, 6));
        $response->assertStatus(200)->assertJson([
            'success' => 'Poprawnie dodano nowe ostrzeżenie',
        ]);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooShortTitle()
    {
        $faker = Faker::create('App\Post');//think of sharing that instance
        $response = $this->prepareTestForStoreMethod('asd',
          $faker->text, $faker->numberBetween(1, 6));
        $response->assertStatus(422);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooLongTitle()
    {
        $faker = Faker::create('App\Post');
        $title = str_repeat('?', 300);
        $response = $this->prepareTestForStoreMethod($faker->lexify($title),
          $faker->text, $faker->numberBetween(1, 6));
        $response->assertStatus(422);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooShortContent()
    {
        $faker = Faker::create('App\Post');
        $response = $this->prepareTestForStoreMethod($faker->sentence, $faker->text(13), $faker->numberBetween(1, 6));
        $response->assertStatus(422);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooLongContent()
    {
        $faker = Faker::create('App\Post');
        $content = str_repeat('?', 1751);
        $response = $this->prepareTestForStoreMethod($faker->sentence, $faker->lexify($content), $faker->numberBetween(1,6));
        $response->assertStatus(422);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenNoType()
    {
        $faker = Faker::create('App\Post');
        $response = $this->prepareTestForStoreMethod($faker->sentence, $faker->text, null);
        $response->assertStatus(422);
    }

    public function testIfOnlyLoggedUsersCanAddPost()
    {
        $faker = Faker::create('App\Post');
        $response = $this->json('POST', '/add-post',
        [
            'title' => $faker->lexify(str_repeat('?', 24)),
            'content' => $faker->lexify(str_repeat('?', 200)),
            'type' => $faker->numberBetween(1, 10),
        ]);

        $response->assertStatus(401);//unauthorized;
    }

    public function testIfOnlyAuthorCanUpdatePost()
    {
        $faker = Faker::create('App\Post');//optimize it somehow maybe
        $object = $this->prepareCorrectObjectForStoreAndPut($faker);
        $user = User::where('id', '<', 10)->first();
        $postId = Post::where('authorId', "!=", $user->id)->first()->id;
        $response = $this->actingAs($user)->json('PUT', '/put-post' . '/' . $postId, $object);
        $response->assertStatus(302)->assertRedirect('/home');
    }

    public function testIfOnlyLoggedUsersCanUseUpdatePost()
    {
        $faker = Faker::create('App\Post');
        $number = $faker->numberBetween(1, 80);
        $response = $this->get('/update' . '/' .$number)->assertRedirect('/login')
          ->assertStatus(302);
    }

    public function testIfOnlyLoggedUserCanUpdatePost()
    {
        $faker = Faker::create('App\Post');
        $number = $faker->numberBetween(1, 80);
        $object = $this->prepareCorrectObjectForStoreAndPut($faker);
        $response = $this->json('PUT', '/put-post' . '/' . $number, $object);

        $response->assertStatus(401);
    }

    public function testIfPutMethodReturnsSuccessMessageAsValidJsonGivenValidData()
    {
          $faker = Faker::create('App\Post');
          $user = factory(User::class)->create();
          $number = $faker->numberBetween(1, 80);
          $object = $this->prepareCorrectObjectForStoreAndPut($faker);
          $response = $this->actingAs($user)->json('PUT', '/put-post' . '/' . $number, $object);
          $response->assertStatus(200)->assertJson([
              'success' => 'Poprawnie edytowano ostrzeżenie',
          ]);
    }

    private function prepareTestForStoreMethod($title, $content, $type)
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/add-post',
        [
            'title' => $title,
            'content' => $content,
            'type' => $type,
        ]);

        return $response;
    }

    private function prepareCorrectObjectForStoreAndPut($faker)
    {
        return [
            'title' => $faker->lexify(str_repeat('?', 24)),
            'content' => $faker->lexify(str_repeat('?', 200)),
            'type' => $faker->numberBetween(1, 10),
        ];
    }

}
