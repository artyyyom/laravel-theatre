<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NavbarTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->get('/navbars');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [[
                'id',
                'name', 
                'order'
            ]]
        ]);
	
    }
}
