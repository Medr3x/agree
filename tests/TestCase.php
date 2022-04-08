<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private function callArtisan(){
        //Correr Seeders
        \Artisan::call('db:seed');  
        //Instalar passport
        \Artisan::call('passport:install');
    }

    protected function getToken($user, $rol){

        $this->callArtisan();

        //Autenticar Usuario con Rol
        $user->assignRole($rol);

        //Crear Bearer Token
        $tokenResult = $user->createToken(env('APP_NAME').'-API');
        $token = $tokenResult->token;
        $token->save(); 
        
        return $tokenResult->accessToken;
    }
}
