<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->get('/positions');
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
