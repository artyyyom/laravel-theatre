
<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->get('/employees');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [[
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
            ]]
        ]);
    }
    public function testGetOneProfession() {
    	$response = $this->get('/employees/1');
    	$response->assertStatus(200);
    	$response->assertJsonStructure([
            'data' => [[
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
            ]]
        ]);
    }

    public function testGetOne() {
    	$response = $this->get('/employees/1');
    	$response->assertStatus(200);
    	$response->assertJsonStructure([
            'data' => [[
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
            ]]
        ]);
    }
}
