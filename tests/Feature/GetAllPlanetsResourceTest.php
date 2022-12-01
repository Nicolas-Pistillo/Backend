<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAllPlanetsResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllPlanetsResource()
    {
        $person = [
            'name'      => 'Padawan', 
            'email'     => 'test@sail.com', 
            'password'  => 'testing123'
        ];

        $registerEndpoint = $this->post('/api/register', $person);

        $registerEndpoint->assertStatus(200)
                         ->assertJson(['success' => true])
                         ->dump('response.message');

        $token = $registerEndpoint->getData()->response->authorization->token;

        $this->withHeader('Authorization', 'Bearer '. $token)
             ->get('/api/planets/all')
             ->assertStatus(200)
             ->assertJson(['success' => true]);
             
        dump('Recurso de planetas obtenido con éxito');
    }
}
