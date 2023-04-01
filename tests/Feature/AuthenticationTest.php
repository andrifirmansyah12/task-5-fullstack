<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJsonStructure([
                "success",
                "message"
            ]);
    }

    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
            "confirm_password" => "demo12345"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data",
                "success",
                "message"
            ]);
    }

    public function testMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(400)
            ->assertJsonStructure([
                "success",
                "message"
            ]);
    }

    public function testSuccessfulLogin()
    {
        $user = User::factory()->create([
           'email' => 'sample@test.com',
           'password' => bcrypt('sample123'),
        ]);

        $loginData = ['email' => 'sample@test.com', 'password' => 'sample123'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data",
                "success",
                "message"
            ]);

        $this->assertAuthenticated();
    }
}
