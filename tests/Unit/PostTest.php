<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use App\User;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIfStoreMethodReturnsSuccessMessageAsValidJsonGivenValidData()
    {
        $faker = Faker::create('App\Post');
        $response = $this->testPrepareForStoreMethod($faker->sentence, $faker->text,
        $faker->numberBetween(1, 6));
        $response->assertStatus(200)->assertJson([
            'success' => 'Poprawnie dodano nowe ostrzeżenie',
        ]);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooShortTitle()
    {
        $faker = Faker::create('App\Post');//think of sharing that instance
        $response = $this->testPrepareForStoreMethod('asd',
          $faker->text, $faker->numberBetween(1, 6));
        $response->assertStatus(422);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooLongTitle()
    {
        $faker = Faker::create('App\Post');
        $title = str_repeat('?', 300);
        $response = $this->testPrepareForStoreMethod($faker->lexify($title),
          $faker->text, $faker->numberBetween(1, 6));
        $response->assertStatus(422);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooShortContent()
    {
        $faker = Faker::create('App\Post');
        $response = $this->testPrepareForStoreMethod($faker->sentence, $faker->text(13), $faker->numberBetween(1, 6));
        $response->assertStatus(422);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenTooLongContent()
    {
        $faker = Faker::create('App\Post');
        $content = str_repeat('?', 1751);
        $response = $this->testPrepareForStoreMethod($faker->sentence, $faker->lexify($content), $faker->numberBetween(1,6));
        $response->assertStatus(422);
    }

    public function testIfStoreMethodReturnsCorrectStatusGivenNoType()
    {
        $faker = Faker::create('App\Post');
        $response = $this->testPrepareForStoreMethod($faker->sentence, $faker->text, null);
        $response->assertStatus(422);
    }

    private function testPrepareForStoreMethod($title, $content, $type)
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
}
