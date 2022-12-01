<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiWorksTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testApiWorks()
    {
        $response = $this->get('/api/test');

        $response->assertStatus(200);

        $response->dump('response');
    }
}
