<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    private $clientId = 1;
    private $clientSecret = "x21mzlq0ijQMy6IewvJcp5X9pzxjo79rfrldaboD";

    private $userName = "transito2@adinet.com";
    private $userPassword = "12345678";

    public function test_ObtenerTokenConClientIdValido()
    {
        $response = $this->post('/oauth/token',[
            "username" => $this -> userName,
            "password" => $this -> userPassword,
            "grant_type" => "password",
            "client_id" => $this -> clientId,
            "client_secret" => $this -> clientSecret
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "token_type",
            "expires_in",
            "access_token",
            "refresh_token"
        ]);

        $response->assertJsonFragment([
            "token_type" => "Bearer"
        ]);

    }

    public function test_ObtenerTokenConClientIdInvalido()
    {

        $response = $this->post('/oauth/token',[
            "grant_type" => "password",
            "client_id" => "234",
            "client_secret" => Str::Random(8)
        ]);

        $response->assertStatus(401);

        $response->assertJsonFragment([
            "error" => "invalid_client",
            "error_description" => "Client authentication failed",
            "message" => "Client authentication failed"
        ]);
    }

    public function test_ValidarTokenSinEnviarToken()
    {
        $response = $this->get('/api/validate');

        $response->assertStatus(500);
    }

    public function test_ValidarTokenConTokenInvalido()
    {
        $response = $this->get('/api/validate',[
            [ "Authorization" => "Bearer " . Str::Random(40)]
        ]);

        $response->assertStatus(500);
    }

    public function test_ValidarTokenConTokenValido()
    {
        $tokenResponse = $this->post('/oauth/token',[
            "username" => $this -> userName,
            "password" => $this -> userPassword,
            "grant_type" => "password",
            "client_id" => $this -> clientId,
            "client_secret" => $this -> clientSecret
        ]);

        $token = json_decode($tokenResponse -> content(),true);

        $response = $this->get('/api/validate',
            [ "Authorization" => "Bearer " . $token['access_token']]
        );

        $response->assertStatus(200);

    }

    public function test_LogoutSinToken()
    {
        $response = $this->get('/api/logout');

        $response->assertStatus(500);
    }

    public function test_LogoutConTokenInvalido()
    {
        $response = $this->get('/api/logout',[
            [ "Authorization" => "Bearer " . Str::Random(40)]
        ]);

        $response->assertStatus(500);
    }

    public function test_LogoutConTokenValido()
    {
        $tokenResponse = $this->post('/oauth/token',[
            "username" => $this -> userName,
            "password" => $this -> userPassword,
            "grant_type" => "password",
            "client_id" => $this -> clientId,
            "client_secret" => $this -> clientSecret
        ]);

        $token = json_decode($tokenResponse -> content(),true);

        $response = $this->get('/api/logout',
            [ "Authorization" => "Bearer " . $token ['access_token']]
        );

        $response->assertStatus(200);

        $response->assertJsonFragment(
            ['message' => 'Token Revoked']
        );

    }
}
