<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PerformanceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetOne()
    {
        $response = $this->get('/performance/1');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [[
                'id',
                'name', 
                'genre',
                'duration',
                'description',
                'photo_main',
                'photos',
                'employees' => [[
	                'id',
	                'name',
	                'surname', 
	                'middlename',
	                'address',
	                'birthday',
	                'biography',
	                'mobile_number',
	                'biography_short',
	                'photo_main',
	                'photos',
	                'position_id'
                ]],
                'seances' => [[
                	'id',
                	'date',
                	'time',
                	'performance_id',
                	'stage_id',
                	'stage' => [
	                	'id',
	                	'name'
                	]
                ]],
                

            ]]
        ]);
	
    }

   public function testGetPreview() {
   	    $response = $this->get('/performances');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [[
                'id',
                'name', 
                'genre',
                'photo_main',
                'duration',
            ]]
        ]);
	
   }
}
