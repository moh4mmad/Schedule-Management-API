<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationTest extends TestCase
{
    /**
     * Authentication test without username & password
     *
     * @return void
     */

    public function test_MustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    /**
     * Authentication test with username & password
     *
     * @return void
     */

    public function test_SuccessfulLogin()
    {

        $loginData = ['email' => 'sakib@test.org', 'password' => 'password'];

        $this->json('POST', 'api/auth/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "access_token",
                "token_type",
                "expires_in",
                "user" => [
                    'name'
                ],
            ]);
    }

    /**
     * Test logout.
     *
     * @return void
     */
    public function testLogout()
    {
        $user = User::where('email', 'sakib@test.org')->first();
        $token = JWTAuth::fromUser($user);

        $this->json(
            'POST',
            'api/auth/logout',
            [],
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token]
        )->assertStatus(200)
            ->assertExactJson([
                'message' => 'Successfully logged out'
            ]);
    }
}
