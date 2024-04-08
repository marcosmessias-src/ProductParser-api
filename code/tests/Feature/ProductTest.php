<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    Use RefreshDatabase;

    /**
     * Verifica a resposta ao acessar a rota Show de produtos sem um token de autorização
     */
    public function test_with_authorization_token_show_route(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->get('api/products');

        $response->assertOk();
    }

    /**
     * Verifica a resposta ao acessar a rota Show de produtos sem um token de autorização
     */
    public function test_without_authorization_token_show_route(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'aplication/json',
        ])->get('api/products');

        $response->assertUnauthorized();
    }

    /**
     * Verifica a resposta ao acessar a rota Put de produtos sem um token de autorização
     */
    public function test_without_authorization_token_put_route(): void
    {
        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Accept' => 'aplication/json',
        ])->put('api/products/'.$product->code, [
            'quantity' => 5
        ]);

        $response->assertUnauthorized();
    }
}
