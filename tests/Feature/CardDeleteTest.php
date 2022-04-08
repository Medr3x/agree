<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Card;
class CardDeleteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_card_delete()
    {
       $this->withoutExceptionHandling();
        //Crear usuario con rol especifico y obtener el token para estar autenticado al llamar al endpoint.
        $rol = 'card_makers';
        $faker = \Faker\Factory::create();
        $user = User::factory()->create();
        $token = $this->getToken($user, $rol);
        //Crear Header
        $params = $this->buildParams($token);
        
        //Consumir el EndPoint con Body y Headers
        
        $card = Card::factory()->create();
        \Log::error($card->id);
        $response = $this->delete('/api/cards/'.$card->id, [], $params['headers']);

        $response->assertStatus(200)
                // ->dump() // Esto lo uso porque no sabemos que nombre la imgen tiene o el id de la categoria.
                ->assertJson([
                    "status"=>"Eliminado!",
                    "message"=>"La carta se elimino correctamente",
                ]);
    }

    private function buildParams($token){
        $params['headers'] = [
            'Authorization' => 'Bearer ' . $token,
        ];
         
        return $params;
    }
}
