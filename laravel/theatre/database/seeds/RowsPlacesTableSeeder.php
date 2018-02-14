<?php

use Illuminate\Database\Seeder;

class RowsPlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rows_places')->insert([
            'row_id' => 1,
            'place_id' => 1,
            'category_id' => 1,
            'price' => '120',
            'status' => 0            
        ]
        );
        DB::table('rows_places')->insert([
            'row_id' => 2,
            'place_id' => 1,
            'category_id' => 2,
            'price' => '60',
            'status' => 0   
        ]
        );
    }
}
