<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function test_can_list_users(): void
    {
        // Criação de um usuário e autenticação com Sanctum
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        // Criação de usuários adicionais para teste
        $users = User::factory()->count(5)->create();

        // Faz uma requisição GET ao endpoint /users com autenticação
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/users');

        // Verifica se a resposta tem status 200
        $response->assertStatus(200);

        // Verifica se a estrutura da resposta contém a lista de usuários dentro de 'data'
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ]
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active'
                    ]
                ],
                'path',
                'per_page',
                'to',
                'total'
            ]
        ]);

        // Verifica se a quantidade de usuários na resposta é a mesma da criação
        $this->assertCount(6, $response->json('data')); // 5 criados + 1 autenticado
    }


    public function test_can_view_single_user(): void
    {
        // Criação de um usuário e autenticação com Sanctum
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        // Criação de um usuário adicional para teste
        $testUser = User::factory()->create();

        // Faz uma requisição GET ao endpoint /users/{user} com autenticação
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/users/{$testUser->id}");

        // Verifica se a resposta tem status 200
        $response->assertStatus(200);

        // Verifica se a estrutura da resposta contém os detalhes do usuário dentro de 'data'
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ]
        ]);

        // Verifica se os dados do usuário na resposta são os mesmos da criação
        $response->assertJson([
            'data' => [
                'id' => $testUser->id,
                'name' => $testUser->name,
                'email' => $testUser->email,
                'email_verified_at' => $testUser->email_verified_at->toJSON(),
                'created_at' => $testUser->created_at->toJSON(),
                'updated_at' => $testUser->updated_at->toJSON()
            ]
        ]);
    }

    public function test_can_view_single_user_not_found(): void
    {
        // Criação de um usuário e autenticação com Sanctum
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        // Utiliza um ID que não existe
        $nonExistentUserId = 9999; // ou qualquer ID que você sabe que não existe

        // Faz uma requisição GET ao endpoint /users/{user} com autenticação
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/users/{$nonExistentUserId}");

        // Verifica se a resposta tem status 404
        $response->assertStatus(404);

        // Verifica a estrutura da resposta de erro
        $response->assertJson([
            'error' => 'Not Found',
            'message' => 'Record not found.',
            'code' => 404
        ]);
    }
}
