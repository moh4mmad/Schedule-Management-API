<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductTest extends TestCase
{

    use WithFaker;

    /**
     * Get all products.
     *
     * @return void
     */
    public function testGetProducts()
    {
        $user = User::where('email', 'sakib@test.org')->first();
        $token = JWTAuth::fromUser($user);

        $this->json(
            'GET',
            'api/products',
            [],
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token]
        )->assertStatus(200)
            ->assertJsonStructure([
                'status', 'products'
            ]);
    }

    /**
     * Test store product.
     *
     * @return void
     */
    public function testStoreProduct()
    {
        $user = User::where('email', 'sakib@test.org')->first();
        $token = JWTAuth::fromUser($user);

        $this->json(
            'POST',
            'api/products',
            [
                'title' => $this->faker->sentence(4),
                'description' => $this->faker->sentence(280),
                'price' => $this->faker->numberBetween($min = 1500, $max = 6000)
            ],
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token]
        )->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * Test View product.
     *
     * @return void
     */
    public function testViewProduct()
    {
        $user = User::where('email', 'sakib@test.org')->first();
        $token = JWTAuth::fromUser($user);

        $this->json(
            'GET',
            'api/products/36',
            [],
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token]
        )->assertStatus(200)
            ->assertJsonStructure([
                'product'
            ]);
    }

    /**
     * Test delete product.
     *
     * @return void
     */
    public function testDeleteProduct()
    {
        $user = User::where('email', 'sakib@test.org')->first();
        $token = JWTAuth::fromUser($user);

        $this->json(
            'DELETE',
            'api/products/36',
            [],
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token]
        )->assertStatus(200)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
