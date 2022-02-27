<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JWTAuth;
use App\Models\User;

class JobTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetUserJobs()
    {
        $loginData = ['email' => 'imohamedgabr@gmail.com', 'password' => '123456'];
        $token = JWTAuth::attempt($loginData);
        

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('Get', 'api/jobs');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "success" ,
            "message",
            "error",
            "data" => [ ]
        ]);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateUserJobs()
    {
        $faker = \Faker\Factory::create();

        $loginData = ['email' => 'imohamedgabr@gmail.com', 'password' => '123456'];
        $token = JWTAuth::attempt($loginData);
   
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('Get', 'api/jobs', [
            'title' => $faker->text($maxNbChars = 50),
            'description' => $faker->text($maxNbChars = 50)
        ]);


        $response->assertStatus(200);
        $response->assertJsonStructure([
            "success" ,
            "message",
            "error",
            "data" => [ ]
        ]);

    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateUserJobsWithTitleMoreThan100()
    {
        $faker = \Faker\Factory::create();

        $loginData = ['email' => 'imohamedgabr@gmail.com', 'password' => '123456'];
        $token = JWTAuth::attempt($loginData);
   
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->json('Get', 'api/jobs', [
            'title' => $faker->text($maxNbChars = 120),
            'description' => $faker->text($maxNbChars = 50)
        ]);


        $response->assertStatus(200);
        $response->assertJsonStructure([
            "success" ,
            "message",
            "error" => [ ] ,
            "data"
        ]);

    }
}
