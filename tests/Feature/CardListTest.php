<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Card;

class CardListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_card_list()
    {
       // $this->withoutExceptionHandling();
        //Crear usuario con rol especifico y obtener el token para estar autenticado al llamar al endpoint.
        $rol = 'player';
        $user = User::factory()->create();
        $token = $this->getToken($user, $rol);

        //Crear Body y Header
        $params = $this->buildParams($token);
        //Consumir el EndPoint con Body y Headers
        $response = $this->json('GET', '/api/cards', $params['body'], $params['headers']);

        $response->assertStatus(200)
                // ->dump() // Esto lo uso porque no sabemos que nombre la imgen tiene o el id de la categoria.
                ->assertJson([
                    "status"=> "Listado!",
                    "message"=> "Cartas listadas correctamente",
                ]);
    }

    private function buildParams($token){
        $card = Card::factory()->create();
        //Al ejecutar los seeders ya tenemos cartas creadas. 
        $params['body']["filters"] = ["sku_id" => $card->sku_id];

        $params['headers'] = [
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ];
         
        return $params;
    }
}
