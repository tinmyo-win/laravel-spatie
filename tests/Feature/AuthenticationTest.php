<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use Database\Factories\UserFactory;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function incorrect_email_login_will_fail()
    {
        $email = $this->faker()->email();
        $password = 'test';
        $param = [
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->post('/api/login', $param);

        $response->assertStatus(404);

        $response->assertJson(['message' => 'User Not Found']);
    }

    /** @test */
    public function incorrect_password_login_will_fail()
    {
        $email = 'mgmg@g.com';
        $password = 'test';
        User::factory(['email' => $email])->create();

        $param = [
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->post('/api/login', $param);

        $response->assertStatus(400);
        $response->assertJson(['message' => 'Password Incorrect Please Try Again']);
    }

    /** @test */
    public function right_user_will_get_token()
    {
        $email = 'mgmg@g.com';
        $password = 'password'; //default password
        User::factory(['email' => $email])->create();

        $param = [
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->post('/api/login', $param);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }
}
